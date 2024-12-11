export default class Cancion {
    #canciones = []
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

    set canciones(canciones) {
        this.#canciones = canciones;
    }

    get canciones() {
        return this.#canciones;
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

    async cargarCanciones() {
        try {
            const response = await fetch('http://localhost/proyectoVue/proyecto-vue/api/Cancion/GET/listaCanciones.php');
            const result = await response.json();
            if (result.success) {
                this.canciones = result.data;
            } else {
                console.error('Error al obtener canciones:', result.message);
                this.canciones = [];
            }
        } catch (error) {
            console.error('Error de red:', error);
            this.canciones = [];
        }
    }

    obtenerCanciones() {
        return this.canciones;
    }

    cancionesFiltradas() {
        console.log("Filtros aplicados:", this.#filtros);  
        return this.#canciones.filter(cancion => {
            const matchId = this.#filtros.id
                ? cancion.songId.toString().includes(this.#filtros.id)
                : true;
            const matchTitulo = this.#filtros.titulo
                ? cancion.title.toLowerCase().includes(this.#filtros.titulo.toLowerCase())
                : true;
            const matchArtista = this.#filtros.artista
                ? cancion.artist.toLowerCase().includes(this.#filtros.artista.toLowerCase())
                : true;
    
            console.log("Cargando canción:", cancion);  
    
            return matchId && matchTitulo && matchArtista;
        });
    }
    
}
