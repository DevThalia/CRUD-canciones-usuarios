<?php
class Cancion
{
    private $songId;
    private $title;
    private $artist;
    private $album;
    private $year;

    private $connection;
    private $errorMessage;

    public function __construct($dbConnection, $songId = null)
    {
        if ($dbConnection === null) {
            throw new Exception("Error: No se ha establecido la conexión a la base de datos.");
        }

        $this->connection = $dbConnection;

        if ($songId !== null) {
            $this->load($songId);
        }
    }

    // Cargar una canción por su ID
    public function load($songId)
    {
        $query = "SELECT * FROM SONGS WHERE songId = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $songId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->songId = $row['songId'];
                $this->title = $row['title'];
                $this->artist = $row['artist'];
                $this->album = $row['album'];
                $this->year = $row['year'];
                return true;
            } else {
                return $this->setError("No se encontró la canción.");
            }
        } else {
            return $this->setError("Error al ejecutar la consulta.");
        }
        $stmt->close();
    }


    // Crear una nueva canción
    public function create($title, $artist, $album, $year)
    {
        if (empty($title) || empty($artist) || empty($album) || empty($year)) {
            return $this->setError("Todos los campos son obligatorios.");
        }

        $query = "INSERT INTO SONGS (title, artist, album, year) VALUES (?, ?, ?, ?)";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ssss", $title, $artist, $album, $year);

        if ($stmt->execute()) {
            $this->songId = $this->connection->insert_id;
            return true;
        } else {
            return $this->setError("Error al crear la canción.");
        }
    }

    // Actualizar los datos de una canción
    public function update($title, $artist, $album, $year)
    {
        if (empty($this->songId)) {
            return $this->setError("ID de canción no válido.");
        }

        $query = "UPDATE SONGS SET title = ?, artist = ?, album = ?, year = ? WHERE songId = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ssssi", $title, $artist, $album, $year, $this->songId);

        if ($stmt->execute()) {
            return true;
        } else {
            return $this->setError("Error al actualizar la canción.");
        }
    }

    // Eliminar una canción
    public function delete()
    {
        if (empty($this->songId)) {
            return $this->setError("ID de canción no válido.");
        }

        $query = "DELETE FROM SONGS WHERE songId = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $this->songId);

        if ($stmt->execute()) {
            return true;
        } else {
            return $this->setError("Error al eliminar la canción.");
        }
    }

    // Obtener todas las canciones
    public function getAll()
    {
        $query = "SELECT * FROM SONGS";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $canciones = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cancion = [];
                $cancion['songId'] = $row['songId'];
                $cancion['title'] = $row['title'];
                $cancion['artist'] = $row['artist'];
                $cancion['album'] = $row['album'];
                $cancion['year'] = $row['year'];
                $canciones[] = $cancion;
            }
        }
        return $canciones;
    }


    // Obtener canciones paginadas
    public function getPaginated($inicio, $limite)
    {
        $query = "SELECT * FROM SONGS LIMIT ?, ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ii", $inicio, $limite);
        $stmt->execute();
        $result = $stmt->get_result();

        $canciones = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cancion = [];
                $cancion['songId'] = $row['songId'];
                $cancion['title'] = $row['title'];
                $cancion['artist'] = $row['artist'];
                $cancion['album'] = $row['album'];
                $cancion['year'] = $row['year'];
                $canciones[] = $cancion;
            }
        }
        return $canciones;
    }

    // Métodos de acceso
    public function getSongId()
    {
        return $this->songId;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getArtist()
    {
        return $this->artist;
    }
    public function getAlbum()
    {
        return $this->album;
    }
    public function getYear()
    {
        return $this->year;
    }

    // Métodos de modificación
    public function setSongId($songId)
    {
        $this->songId = $songId;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }
    public function setAlbum($album)
    {
        $this->album = $album;
    }
    public function setYear($year)
    {
        $this->year = $year;
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

    public function getError()
    {
        return $this->errorMessage;
    }
}
