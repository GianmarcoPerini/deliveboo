<template>
    <div class="container">

        <!-- <div class="mb-3">
            Remove per pulizia in produzione
            <button @click="removeItems()" class="btn btn-warning">
                Remove items
            </button>
        </div> -->
        <div v-for="piatto in dato" :key="piatto.id" class="row mb-5">
            <div v-show="piatto.available == 1" class="card col-12 col-lg-10 mb-3 mb-lg-0">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <!-- La src dal database dell'immagine dovrebbe essere passata dal blade durante la creazione -->
                        <img
                            :src="piatto.image.startsWith('dishes/images') ? 'http://127.0.0.1:8000/storage/' + piatto.image : piatto.image"
                            class="img-fluid rounded-start"
                            alt="..."
                        />
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ piatto.name }}</h5>
                            <p class="card-text">{{ piatto.description }}</p>
                            <p class="card-text">
                                <span class="text-white bg-danger"
                                    >{{ piatto.price }}€</span
                                >
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-lg-2 d-flex flex-lg-column justify-content-lg-center align-items-center">                
                
                <button v-show="piatto.available == 1" @click="setItems(piatto)" type="submit" class="white-butt mr-3 mr-lg-0 mb-0 mb-lg-3">Aggiungi 1 quantità</button>
                
                <button v-show="piatto.available == 1" @click="delItems(piatto.user_id, piatto.id)" class="sec-butt">Rimuovi dal carrello</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Show",
    props: {
        dato: Array,
    },
    data() {
        return {
            storage_key: "cart_items",
            storageItems: [],
        }
    },

    methods: {
        setItems(piatto) {

            let change = false;
            let items = {};

            // Verifica che ci siano dati nel localStorage e quindi sia già presente una selezione di piatti
            if (localStorage.getItem(this.storage_key)) {
                items = this.getItems();

                // Verifica che il ristorante all'interno del localStorage sia lo stesso dell'evento
                if (this.verifyRestaurant(items.restaurant, piatto.user_id)) {
                    // Controlla se il piatto è già presente nella lista del localStorage
                    const index = items.menu.findIndex(
                        (el) => el.id === piatto.id
                    );

                    // Se il piatto è presente allora aggiunge 1 alla quantità
                    if (index >= 0) {
                        console.log("i piatti corrispondono");
                        change = true;
                        items.menu[index].quantity++;

                        // Altrimenti aggiunge il piatto nella lista come nuovo piatto
                    } else {
                        items.menu.push({
                            id: piatto.id,
                            name: piatto.name,
                            price: piatto.price,
                            quantity: 1,
                            check: false,
                        });
                        change = true;
                    }
                } else {
                    // Altrimenti il ristorante non è lo stesso, e viene richiesta la conferma per la cancellazione del carrello
                    const confirm = window.confirm(
                        "Non puoi aggiungere piatti al carrello di un altro ristorante, proseguendo eliminerai il carrello già esistente"
                    );
                    console.log(confirm);
                    // Se la conferma è positiva restituisce -true- e rimuoviamo tutte le informazioni dal localStorage e poi aggiungiamo il piatto selezionato
                    if (confirm) {
                        this.removeItems();
                        items = {
                            restaurant: piatto.user_id,
                            menu: [
                                {
                                    id: piatto.id,
                                    name: piatto.name,
                                    price: piatto.price,
                                    quantity: 1,
                                    check: false,
                                },
                            ],
                        };
                        change = true;
                    }
                }
            } else {
                // Altrimenti se non è presente nessuna informazione nel localStorage, aggiunge direttamente il piatto come del ristorante
                change = true;
                items = {
                    restaurant: piatto.user_id,
                    menu: [
                        {
                            id: piatto.id,
                            name: piatto.name,
                            price: piatto.price,
                            quantity: 1,
                            check: false,
                        },
                    ],
                };
            }

            if (change) {
                localStorage.setItem(this.storage_key, JSON.stringify(items));
            }
        },

        getItems() {
            return JSON.parse(localStorage.getItem(this.storage_key));
        },

        /**
         * Verifica che il ristorante sia quello selezionato
         * Restituendo vero o falso;
         */
        verifyRestaurant(restaurant_id, user_id) {
            if (restaurant_id === user_id) return true;
            return false;
        },

        /**
         * Rimuove solo un piatto dalla lista, verificando prima di essere nel ristorante corretto
         */
        delItems(user_id, dish_id) {
            let items = {};
            if (localStorage.getItem(this.storage_key)) {
                items = this.getItems();
                if (this.verifyRestaurant(items.restaurant, user_id)) {
                    const index = items.menu.findIndex(
                        (el) => el.id === dish_id
                    );
                    if (index >= 0) {
                        items.menu.splice(index, 1);
                        localStorage.setItem(
                            this.storage_key,
                            JSON.stringify(items)
                        );
                        console.log(items.menu.length);
                        this.cartEmpty(items.menu.length);     
                    }
                }
            }
        },

        // Verifica un intero che corrisponde alla lunghezza della lista menu, se è minore od uguale a zero allora cancella tutto l'item dal localStorage
        cartEmpty(menuLeft) {
            if (menuLeft <= 0) this.removeItems();
        },

        removeItems() {
            localStorage.removeItem(this.storage_key);
        },
    },

    mounted() {
        // this.storageItems = this.getItems();
        // console.log(this.storageItems);
        // console.log(this.dato);
        // console.log(typeof this.dato);
    },
};
</script>

<style>

</style>
