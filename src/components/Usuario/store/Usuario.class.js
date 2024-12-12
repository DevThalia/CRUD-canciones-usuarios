export default class Usuario {
    #usuarios = []
    #loading
    #currentPage
    #itemsPerPage
    #filtros
    #url

    set url(url) {
        this.#url = url;
    }

    get url() {
        return this.#url;
    }

    set usuarios(usuarios) {
        this.#usuarios = usuarios;
    }

    get usuarios() {
        return this.#usuarios;
    }

    set loading(loading) {
        this.#loading = loading;
    }

    get loading() {
        return this.#loading;
    }

    set currentPage(currentPage) {
        this.#currentPage = currentPage;
    }

    get currentPage() {
        return this.#currentPage;
    }

    set itemsPerPage(itemsPerPage) {
        this.#itemsPerPage = itemsPerPage;
    }

    get itemsPerPage() {
        return this.#itemsPerPage;
    }

    set filtros(filtros) {
        this.#filtros = filtros;
    }

    get filtros() {
        return this.#filtros;
    }

    async cargarUsuarios() {
        try {
            const response = await fetch('http://localhost/proyectoVue/proyecto-vue/api/Usuario/GET/listaUsuarios.php');
            const result = await response.json();
            if (result.success) {
                this.usuarios = result.data;
            } else {
                console.log(result.message);
                this.usuarios = [];
            }

        } catch (error) {
            console.log(error);
            this.usuarios = [];
        }
    }

    obtenerUsuarios() {
        return this.usuarios;
    }

    usuariosFiltrados() {
        console.log(this.#filtros);
        return this.#usuarios.filter(usuario => {
            const matchId = this.#filtros.id
                ? usuario.userId.toString().startsWith(this.#filtros.id)
                : true;
            const matchNombre = this.#filtros.nombre
                ? usuario.name.toLowerCase().startsWith(this.#filtros.nombre.toLowerCase())
                : true;
            const matchTlf = this.#filtros.telefono
                ? usuario.phone.toLowerCase().startsWith(this.#filtros.telefono.toLowerCase())
                : true;
            return matchId && matchNombre && matchTlf;
        });
    }
}