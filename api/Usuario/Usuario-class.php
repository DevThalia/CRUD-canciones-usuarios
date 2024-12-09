<?php
class Usuario
{
    private $userId;
    private $name;
    private $username;
    private $email;
    private $phone;
    private $password;
    private $nivel;

    private $connection;
    private $errorMessage;

    public function __construct($dbConnection, $userId = null)
    {
        if ($dbConnection === null) {
            throw new Exception("Error: No se ha establecido la conexión a la base de datos.");
        }

        $this->connection = $dbConnection;

        if ($userId !== null) {
            $this->load($userId);
        }
    }

    // Registrar un nuevo usuario
    public function register()
    {
        if (empty(trim($this->name)) || empty(trim($this->password))) {
            return $this->setError("Todos los campos son obligatorios.");
        }
        $nivel = 'user';
        $query = "INSERT INTO USERS (name, password, nivel) VALUES (?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            return $this->setError("Error al preparar la consulta: " . $this->connection->error);
        }
        $stmt->bind_param("sss", $this->name, $this->password, $nivel);  
        if ($stmt->execute()) {
            $this->userId = $this->connection->insert_id;
            return true;
        } else {
            return $this->setError("Error al registrar el usuario: " . $stmt->error);
        }
    }



    // Iniciar sesión
    public function login()
    {
        if (empty($this->email) || empty($this->password)) {
            return $this->setError("Todos los campos son obligatorios.");
        }

        $query = "SELECT * FROM USERS WHERE email = ? AND password = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ss", $this->email, $this->password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->userId = $row['userId'];
            $this->name = $row['name'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->phone = $row['phone'];
            return true;
        } else {
            return $this->setError("Usuario o contraseña incorrectos.");
        }
    }

    // Cargar los datos de un usuario por su ID
    public function load($userId)
    {
        $query = "SELECT * FROM USERS WHERE userId = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->userId = $row['userId'];
                $this->name = $row['name'];
                $this->username = $row['username'];
                $this->email = $row['email'];
                $this->phone = $row['phone'];
            } else {
                $this->setError("No se encontró el usuario.");
            }
        } else {
            $this->setError("Error al ejecutar la consulta.");
        }
        $stmt->close();
    }

    // Crear un nuevo usuario
    public function create($name, $username, $email, $phone)
    {
        if (empty($name) || empty($username) || empty($email) || empty($phone)) {
            return $this->setError("Todos los campos son obligatorios.");
        }

        $query = "INSERT INTO USERS (name, username, email, phone) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ssss", $name, $username, $email, $phone);

        if ($stmt->execute()) {
            $this->userId = $this->connection->insert_id;
            return true;
        } else {
            return $this->setError("Error al crear el usuario.");
        }
    }

    // Actualizar los datos de un usuario
    public function update($name, $username, $email, $phone)
    {
        if (empty($this->userId)) {
            return $this->setError("ID de usuario no válido. Asegúrate de cargar el usuario antes de actualizar.");
        }
        if (empty($name) || empty($username) || empty($email) || empty($phone)) {
            return $this->setError("Todos los campos son obligatorios para actualizar.");
        }
        $query = "UPDATE USERS SET name = ?, username = ?, email = ?, phone = ? WHERE userId = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ssssi", $name, $username, $email, $phone, $this->userId);
        if ($stmt->execute()) {
            return true;
        } else {
            return $this->setError("Error al actualizar el usuario.");
        }
    }


    // Eliminar un usuario
    public function delete()
    {
        if (empty($this->userId)) {
            return $this->setError("ID de usuario no válido.");
        }

        $query = "DELETE FROM USERS WHERE userId = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $this->userId);

        if ($stmt->execute()) {
            return true;
        } else {
            return $this->setError("Error al eliminar el usuario.");
        }
    }

    // Obtener un usuario por su ID
    public function getById()
    {
        if (empty($this->userId)) {
            return null;
        }

        $query = "SELECT * FROM USERS WHERE userId = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Usuario($this->connection, $row['userId']);
        }
        return null;
    }


    // Obtener todos los usuarios
    public function getAll()
    {
        $query = "SELECT * FROM USERS";
        $result = $this->connection->query($query);

        $usuarios = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuario = [];
                $usuario['userId'] = $row['userId'];
                $usuario['name'] = $row['name'];
                $usuario['username'] = $row['username'];
                $usuario['email'] = $row['email'];
                $usuario['phone'] = $row['phone'];
                $usuarios[] = $usuario;
            }
        }
        return $usuarios;
    }

    // Obtener usuarios paginados
    public function getPaginated($inicio, $limite)
    {
        $query = "SELECT * FROM USERS LIMIT ?, ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ii", $inicio, $limite);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuarios = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuario = [];
                $usuario['userId'] = $row['userId'];
                $usuario['name'] = $row['name'];
                $usuario['username'] = $row['username'];
                $usuario['email'] = $row['email'];
                $usuario['phone'] = $row['phone'];
                $usuarios[] = $usuario;
            }
        }
        return $usuarios;
    }

    // Métodos de acceso
    public function getUserId()
    {
        return $this->userId;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPhone()
    {
        return $this->phone;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getNivel()
    {
        return $this->nivel;
    }

    // Métodos de modificación
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }

    // Manejar errores
    private function setError($errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return false;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
