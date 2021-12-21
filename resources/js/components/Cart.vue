<template>
    <div class="container">
        <div class="row flex-column">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, i) in cartItems.menu" :key="i">
                        <th scope="col">
                            <input
                                type="checkbox"
                                @change="selection(item)"
                                @click="item.check = !item.check" 
                                v-model="item.check"

                                
                            />
                        </th>
                        <th>{{ item.name }}</th>
                        <td>{{ item.price }}€</td>
                        <td>
                            <button
                                class="mx-2 p-2 btn btn-primary"
                                @click="pick(item)"
                            >
                                -
                            </button>

                            {{ item.quantity }}

                            <button
                                class="mx-2 p-2 btn btn-primary"
                                @click="add(item)"
                            >
                                +
                            </button>
                        </td>
                        <td>
                            <button
                                class="btn btn-danger"
                                @click="remove(item)"
                            >
                                Remove
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            

            <!-- Link alla pagina del pagamento -->
            <a @click="confirmOrder" :href="cartItems.menu[0].check == true ? `${confirm}` : '#' " class="btn btn-success">Conferma Ordine</a>
            
            <!-- <button class="btn btn-success" @click="confirmOrder">
                Confirm Order
            </button> -->
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            cartItems: {},
            orderItem: {},
            STORAGE_KEY: "cart_items",
            STORAGE_KEY_CONFIRM: "cart_confirm",
            confirm: '/guest/payment'
        };
    },

    created() {
        this.cartItems = JSON.parse(
            localStorage.getItem(this.STORAGE_KEY)
        );
        //Inizializzo l'oggetto orderItem dandogli le proprietà di partenza
        this.orderItem.restaurant = this.cartItems.restaurant;
        this.orderItem.menu = [];
        console.log(this.cartItems.menu);
    },

    methods: {
        add(item) {
            item.quantity++;
        },

        pick(item) {
            if (item.quantity > 1) item.quantity--;
        },

        remove(item) {
            this.cartItems.menu.splice(this.cartItems.menu.indexOf(item), 1);
            localStorage.setItem(
                this.STORAGE_KEY,
                JSON.stringify(this.cartItems)
            );
        },

        // confirmOrder() {
        //     if (this.orderItem.length == 0) {
        //         alert("inserischi");
        //     } else {
        //         localStorage.setItem(
        //             this.STORAGE_KEY_CONFIRM,
        //             JSON.stringify(this.orderItem)
        //         );
        //     }
        // },

        confirmOrder () {
            if (this.orderItem.menu.length == 0) {
                alert("Seleziona un piatto dalla lista.");
            } else {
                let total = 0;
                console.log(this.orderItem.menu.length);
                this.orderItem.menu.forEach(el => {
                    total += el.price * el.quantity;
                });

                this.orderItem.total = total;
                
                localStorage.setItem(this.STORAGE_KEY, JSON.stringify(this.orderItem));
            }
        },

        selection(item) {
            console.log('click');
            if (item.check) {
                this.orderItem.menu.push(item);
            } else {
                this.orderItem.menu.splice(this.orderItem.menu.indexOf(item), 1);
            }
            console.log(this.orderItem);
        },
    },
};
</script>

<style></style>
