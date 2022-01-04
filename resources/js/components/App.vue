<template>
	<!-- Search bar -->
	<div class="d-flex container-fluid">
		<div class="rest">
			<section class="customer--search">
				<input
					class="col-12 input--search fontAwesome"
					placeholder="🔎 Cerca un ristorante"
					@keydown="selected.page = 1"
					type="text"
					v-model="selected.query" />
			</section>

			<Slider />

			<div class="d-flex align-items-center">
				<i class="fas fa-utensils mr-3"></i>
				<p class="m-0">Le cucine più richieste</p>
			</div>

			<section class="input--checkbox">
				<div class="d-flex flex-wrap">
					<div v-for="type in types" :key="type.id">
						<input
							class="d-none"
							type="checkbox"
							:id="`input${type.id}`"
							:value="type.name"
							v-model="selected.checked"
							@click="(selected.page = 1), check(type)" />
						<label :for="`input${type.id}`">
							<div class="cat mr-2">
								<img
									:class="type.isCheck == 1 ? 'active' : ''"
									:src="type.img"
									alt="" />
								<p>{{ type.name }}</p>
							</div>
						</label>
					</div>
				</div>
			</section>
			<Restaurant :users="users" />

			<section class="d-flex justify-content-center">
				<button class="mx-3" @click="previusPage">prev</button>
				<button class="mx-3" @click="nextPage">next</button>
			</section>
		</div>
		<Order />
	</div>
</template>

<script>
import Slider from './slider.vue';
import Restaurant from './Restaurant.vue';
import Order from './Order.vue';

export default {
	components: { Slider, Restaurant, Order },
	name: 'App',
	data() {
		return {
			users: [], // array degli user
			types: [], // array di tutte le tipologie
			lastPage: 0,
			currentPage: 0,
			selected: {
				// input ricevuti
				checked: [], // checkbox
				query: '', // ricerca piatti per nome
				page: 1, // pagina corrente
			},
		};
	},

	methods: {
		check(i) {
			console.log(i);
			i.isCheck == 0 ? (i.isCheck = 1) : (i.isCheck = 0);
		},

		usersList() {
			axios
				.get('/api/user', {
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
			axios
				.get('api/type')
				.then((res) => (this.types = res.data));
		},
		nextPage() {
			if (this.currentPage < this.lastPage)
				this.selected.page++;
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
	},
};
</script>

<style lang="scss" scoped>
.rest {
	width: 70%;
}
.order {
	width: 30%;
}
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
	border: 3px solid #ff3300 !important;
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

.input--search {
	border-color: transparent;
	box-shadow: 1px 2px 4px rgba(190, 190, 190, 0.74);
	border-radius: 50px;
	height: 3rem;
}

@media screen and (max-width: 677px) {
	.order {
		display: none;
		width: 0%;
	}
	.rest {
		width: 100%;
	}
}
</style>
