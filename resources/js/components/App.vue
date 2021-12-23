<template>
  <div class="container">
    <div class="d-flex align-items-center">
      <i class="fas fa-utensils mr-3"></i>
      <p class="m-0">Le cucine più richieste</p>
    </div>

    <section class="input--checkbox">
      <div class="d-flex">
        <div v-for="type in types" :key="type.id">
          <input
            class="d-none"
            type="checkbox"
            :id="`input${type.id}`"
            :value="type.name"
            v-model="selected.checked"
            @click="(selected.page = 1), check(type), log(type)"
          />
          <label :for="`input${type.id}`">
            <div class="cat mr-2">
              <img
                :class="type.isCheck == 1 ? 'active' : ''"
                :src="type.img"
                alt=""
              />
              <p>{{ type.name }}</p>
            </div>
          </label>
        </div>
      </div>
    </section>

    <section class="customer--search">
      <input
        class="col-12 input--search"
        placeholder="Cerca un ristorante"
        @keydown="selected.page = 1"
        type="text"
        v-model="selected.query"
      />
    </section>

    <section class="restaurant m-3">
      <div
        v-for="user in users"
        :key="user.id"
        class="d-flex m-4 restaurant--box"
      >
        <div class="img--box">
          <img :src="user.image" alt="" />
        </div>
        <div class="info ml-4" @click="log(user)">
          <h4>
            <a :href="`guest/user/${user.id}`">{{ user.name }}</a>
          </h4>
          <span v-for="type in user.types" :key="type.id" class="mr-1">{{
            type.name
          }}</span>
        </div>
        <div class="info ml-auto d-flex justify-content-center flex-column">
          <div>
            <i class="mr-3 fas fa-lock-open"></i>Orario di apertura:
            {{ user.open }}
          </div>
          <div>
            <i class="mr-3 fas fa-lock"></i>Orario di chiusura: {{ user.close }}
          </div>
        </div>
      </div>
    </section>

    <section class="d-flex justify-content-center">
      <button class="mx-3" @click="previusPage">prev</button>
      <button class="mx-3" @click="nextPage">next</button>
    </section>
  </div>
</template>

<script>
export default {
  name: "App",
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
    check(i) {
      i.isCheck == 0 ? (i.isCheck = 1) : (i.isCheck = 0);
    },
    log(i) {
      console.log(i);
    },
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
      if (this.currentPage < this.lastPage) this.selected.page++;
    },
    previusPage() {
      if (this.currentPage > 1) this.selected.page--;
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
    console.log(this.types);
  },
};
</script>

<style lang="scss" scoped>
.cat {
  text-align: center;
  border: 3px solid transparent;

  img {
    border-radius: 100px;
    width: 100px;
    height: 100px;
    border: 3px solid transparent;
  }
}

.active {
  border: 3px solid blue !important;
}

button {
  background-color: #ff8000;
  padding: 5px 10px;
  border: none;
  border-radius: 10px;
  color: white;

  &:active {
    box-shadow: 1px 1px 3px rgb(117, 117, 117);
  }
}
h4 {
  a {
    text-decoration: none;
    color: black;

    &:hover {
      text-decoration: underline;
    }
  }
}

.input--search {
  border-color: transparent;
  box-shadow: 1px 2px 4px rgba(190, 190, 190, 0.74);
  border-radius: 50px;
  height: 3rem;
}
.restaurant--box {
  background-color: #e7e7e7b9;
  border-radius: 20px;
  padding: 10px;

  .img--box {
    height: 100px;
    width: 180px;
    border-radius: 20px;
    overflow: hidden;

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }
}
</style>
