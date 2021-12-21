<template>
    <div class="container">

        <!-- <div class="mb-3">
            Remove per pulizia in produzione
            <button @click="removeItems()" class="btn btn-warning">
                Remove items
            </button>
        </div> -->
        <div v-for="(piatto) in dato" :key="piatto.id" class="row mb-5">
            <div v-show="piatto.available == 1" class="card col-12 col-lg-10 mb-3 mb-lg-0">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <!-- La src dal database dell'immagine dovrebbe essere passata dal blade durante la creazione -->
                        <img :src="piatto.image.startsWith('dishes/images') ? 'http://127.0.0.1:8000/storage/' + piatto.image : piatto.image" class="img-fluid rounded-start" alt="..." />
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ piatto.name }}</h5>
                            <p class="card-text">{{ piatto.description }}</p>
                            <p class="card-text">
                                <span class="text-white bg-danger">{{ piatto.price }}€</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-lg-2 d-flex flex-lg-column justify-content-lg-center align-items-center">                
                
                <button v-if="piatto.available == 1" @click="setItems(piatto), add(piatto)" type="submit" class="white-butt mr-3 mr-lg-0 mb-0 mb-lg-3">Aggiungi 1 quantità 
                </button>
                <input v-if="piatto.available == 1" type="number" class="qnt" value="0">
                <button v-if="piatto.available == 1" @click="delItems(piatto)" class="sec-butt">Rimuovi dal carrello</button>
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

        // return true of false if on the local storage we have dish from different restaurant.id
        check(piatto){
            let check
            if(this.getItems()){
                const item = this.getItems()
                item.forEach(el => {
                    if(el.restaurantId == piatto.user_id || item.length == 0) check = true
                    else check = false
                })
            }else{
                check = true
            }
            return check
        },
        
        setItems(piatto) {
            // if the controll is true
            if(this.check(piatto)){
                // if local storage is empty
                if(!this.getItems()){
                    //push everything and save 
                    this.pushItem(piatto)
                    this.addItems()
                }else{
                    // otherwise get all items and add 1 to the quantity if dish exist, add the new dish if don't exist
                    this.storageItems = this.getItems()
                    const i = this.storageItems.findIndex(el => el.id === piatto.id) +1
                    if( i ){
                        this.storageItems = this.getItems()
                        this.storageItems[i -1].quantity++
                        this.addItems()
                    }else{
                        this.pushItem(piatto)
                        this.addItems()
                    }
                }
            // if the controll is false
            }else{
                // ask the confirm to delete all old dish and add newest ones
                const confirm = window.confirm("Non puoi aggiungere piatti al carrello di un altro ristorante, proseguendo eliminerai il carrello già esistente");
                if (confirm) {
                    localStorage.clear()
                    this.pushItem(piatto)
                    this.addItems()
                }
            }
            
        },
        delItems(piatto) {
            this.storageItems = this.getItems()
            // (check the index of the dishes from the arrays) 
            let i = this.storageItems.findIndex(el => el.id == piatto.id) +1

            if (i) {
                // remove from the object.quantity 1 (and save changes) until the quantity is 0
                this.storageItems[i -1].quantity--
                console.log(this.storageItems[i -1].quantity)
                this.addItems()

                // if quantity is 0 delete the entire object
                if(!this.storageItems[i -1].quantity){
                    this.storageItems.splice(i -1, 1);
                    this.addItems()
                }
            }
            // if the length of the array is 0 delete the entire array
            if(this.storageItems.length <= 0) localStorage.removeItem(this.storage_key)
        },

        pushItem(piatto){
            this.storageItems.push({restaurantId:piatto.user_id, id: piatto.id, name: piatto.name, price: piatto.price, quantity: 1})
        },
        addItems(){
            localStorage.setItem(this.storage_key, JSON.stringify(this.storageItems));
        },

        getItems() {
            return JSON.parse(localStorage.getItem(this.storage_key));
        },
    },
};
</script>

<style>

</style>
