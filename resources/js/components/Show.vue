<template>
  <div class="container">
    <section class="restaurant-show"></section>
    <section class="dishes">
      <section class="dishes-choise"></section>
      <section class="order"></section>
    </section>
  </div>
</template>

<script>
import "@fortawesome/fontawesome-free/js/all.js";
export default {
  name: "Show",
  props: {
    dato: Array,
    user: Object,
  },
  data() {
    return {
      storage_key: "cart_items",
      storageItems: [],
      qnt: 0,
    };
  },

  created() {
    this.storageItems = this.getItems();
    this.storageItems.forEach((el) => (this.qnt += el.quantity));
  },

  methods: {
    // return true of false if on the local storage we have dish from different restaurant.id
    check(piatto) {
      let check;
      if (this.getItems().length > 0) {
        const item = this.getItems();
        item.forEach((el) =>
          el.restaurantId == piatto.user_id ? (check = true) : (check = false)
        );
      } else {
        check = true;
      }
      return check;
    },

    setItems(piatto) {
      console.log(piatto);
      // if the controll is true
      if (this.check(piatto)) {
        // if local storage is empty
        if (this.getItems() > 0) {
          //push everything and save
          this.qnt = 1;
          this.pushItem(piatto);
          this.addItems();
        } else {
          // otherwise get all items and add 1 to the quantity if dish exist, add the new dish if don't exist
          this.storageItems = this.getItems();
          const i =
            this.storageItems.findIndex((el) => el.id === piatto.id) + 1;
          if (i) {
            this.storageItems = this.getItems();
            this.storageItems[i - 1].quantity++;
            this.qnt++;
            this.addItems();
          } else {
            this.qnt++;
            this.pushItem(piatto);
            this.addItems();
          }
        }
        // if the controll is false
      } else {
        // ask the confirm to delete all old dishes and add newest ones
        const confirm = window.confirm(
          "Non puoi aggiungere piatti al carrello di un altro ristorante, proseguendo eliminerai il carrello già esistente"
        );

        if (confirm) {
          localStorage.clear();
          this.qnt = 1;
          this.storageItems = this.getItems();
          this.pushItem(piatto);
          this.addItems();
        }
      }
    },
    delItems(piatto) {
      this.storageItems = this.getItems();
      // (check the index of the dishes from the arrays)
      let i = this.storageItems.findIndex((el) => el.id == piatto.id) + 1;

      if (i) {
        // remove from the object.quantity 1 (and save changes) until the quantity is 0
        this.storageItems[i - 1].quantity--;
        this.qnt--;
        this.addItems();

        // if quantity is 0 delete the entire object
        if (!this.storageItems[i - 1].quantity) {
          this.storageItems.splice(i - 1, 1);
          this.addItems();
        }
      }
      // if the length of the array is 0 set an empty array
      if (this.storageItems.length <= 0)
        localStorage.removeItem(this.storage_key);
    },

    pushItem(piatto) {
      this.storageItems.push({
        restaurantId: piatto.user_id,
        id: piatto.id,
        name: piatto.name,
        price: piatto.price,
        quantity: 1,
      });
    },
    addItems() {
      localStorage.setItem(this.storage_key, JSON.stringify(this.storageItems));
    },
    getItems() {
      return JSON.parse(localStorage.getItem(this.storage_key) || "[]");
    },
  },
};
</script>

<style scoped>
</style>
