<template>
    <div class="container">

            <div class="jambotron mb-5 pb-sm-3">
                <div class="row">
                    <div class="col-12 my_img"></div>
                </div>
            </div>

        <div class="row mb-5 text-center search">
            <div class="col-lg-3 col-12 mb-3">
                <input class="col-12 white-input" placeholder="Cerca un ristorante" @keydown="selected.page = 1" type="text" v-model="selected.query" />
            </div>
            
            <div class="col-lg-9 col-md-12 mt-3 d-flex flex-wrap">
                <div 
                    v-for="type in types"
                    :key="type.id"
                    class="d-inline mx-2 input"
                >
                    <input class="check"
                        type="checkbox"
                        :id="`input${type.id}`"
                        :value="type.name"
                        v-model="selected.checked"
                        @click="selected.page = 1"
                    />
                    <label class="text-input" :for="`input${type.id}`">{{ type.name }}</label>
                </div>
            </div>
        </div>
        

        <div class="row mt-5">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-5 d-flex justify-content-center" v-for="user in users" :key="user.id">
                
                <div class="card" style="width: 18rem">
                    <img :src="user.image.startsWith('users/images') ? 'http://127.0.0.1:8000/storage/' + user.image : user.image" class="card-img-top" :alt="user.image" />
                    <div class="card-body">
                        <p>{{ user.name }}</p>
                        <p class="restaurant-descr">{{ user.description }}</p>
                        <a
                            :href="`/guest/user/${user.id}`"
                            class="btn white-butt white-butt-hover"
                            >Entra nel Menu del Ristorante</a
                        >
                    </div>
                </div>
                
            </div>
        </div>

        
        <div class="row justify-content-center">
            <button
                class="btn white-butt mx-3"
                v-if="currentPage > 1"
                @click="previusPage"
            >
                prev
            </button>

            <button
                class="btn white-butt mx-3"
                v-if="currentPage < lastPage"
                @click="nextPage"
            >
                next
            </button>
        </div>
    </div>
    
</template>

<script>
export default {
    name: "App",
    props: ["dato"],
    data() {
        return {
            users: [], // array degli user
            types: [], // array di tutte le tipologie
            lastPage: 0,
            currentPage: 0,
            selected: {
                // input ricevuti
                checked: [], // checkbox
                query: "", // ricerca piatti per nome
                page: 1, // pagina corrente
            },
        };
    },

    methods: {
        usersList() {
            axios
                .get("/api/user", {
                    params: {
                        type: this.selected.checked,
                        user: this.selected.query,
                        page: this.selected.page,
                    },
                })
                .then((res) => {
                    this.users = res.data.data;
                    this.lastPage = res.data.last_page;
                    this.currentPage = res.data.current_page;
                });
        },
        typesList() {
            axios.get("api/type").then((res) => (this.types = res.data));
        },
        nextPage() {
            this.selected.page++;
        },
        previusPage() {
            this.selected.page--;
        },
    },

    watch: {
        // la funzione resta "in ascolto" degli input che vengono inseriti dall'utente,
        selected: {
            //appena viene compiuto un cambiamento viene fatta una nuova chiamata che aggiorna i parametri
            handler: function () {
                this.usersList();
            },
            deep: true,
        },
    },

    mounted() {
        this.usersList();
        this.typesList();
    },
};
</script>

<style lang="scss">

    .text-input{
        color:white;
        font-size: 0.9rem;
        font-style: italic;
        // box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
    }

    .white-input{
        font-size: 1.2em;
        font-weight: 200;
        font-style: italic;
        padding: 10px 15px 10px 20px;
        color: black;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
    }

    .jambotron{
        width: 100%;    
        background-image: url("https://www.destinationperth.com.au/sites/default/files/styles/og/public/2021-06/tonic-and-ginger-jumbotron.jpg?itok=plccaT1D");
        background-size: cover;
        background-position-x: center;
        background-repeat: no-repeat;

        .my_img{   
            min-height: 500px;
        }
    }

    .card{
        border: 1px, solid, black;

        p{
            font-size: 1.5em;
            font-style: italic;
            font-weight: 600;
        };

        .restaurant-descr{
            font-size: 1rem;
            font-weight:300;
        }
    }
    
</style>
