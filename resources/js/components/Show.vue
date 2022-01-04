<template>
	<div class="d-flex container">
		<section class="dishes">
			<div v-for="piatto in dato" :key="piatto.id">
				<p>{{ piatto.name }}</p>
				<button @click="setItems(piatto), setTotal()">
					add
				</button>
				<button @click="delItems(piatto), setTotal()">
					del
				</button>
			</div>
			<div>{{ qnt }}</div>
		</section>

		<section class="p-3 order">
			<h2 class="title">Order Menù</h2>
			<div class="order--list">
				<div
					class="order--dish"
					v-for="item in storageItems"
					:key="item.id">
					<div class="ml-3 d-flex align-items-center">
						<div class="dish--img">
							<img :src="item.img" alt="" />
						</div>
						<div class="ml-3">
							<div class="dish--name">
								{{ item.name }}
							</div>
							<div class="dish--qnt">x {{ item.quantity }}</div>
						</div>
					</div>
					<div class="dish--price mr-3">{{ item.price }}</div>
				</div>
			</div>
			<div class="total d-flex justify-content-between m-3">
				{{ total }}
			</div>
			<div>
				<button class="m-3 btn checkout">Check Out</button>
			</div>
		</section>
	</div>
</template>

<script>
import '@fortawesome/fontawesome-free/js/all.js';

export default {
	name: 'Show',

	props: {
		dato: Array,
		user: Object,
	},
	data() {
		return {
			storage_key: 'cart_items',
			storageItems: [],
			qnt: 0,
			total: [],
			bool: false,
		};
	},

	created() {
		this.storageItems = this.getItems();
		this.storageItems.forEach(
			(el) => (this.qnt += el.quantity)
		);
		this.setTotal();
	},

	methods: {
		setTotal() {
			let sum = 0;
			this.storageItems.forEach((item) => {
				const price = item.price;
				const qnt = item.quantity;
				sum += price * qnt;
			});

			this.total = sum;
		},

		update() {
			this.bool = !this.bool;
		},
		check(piatto) {
			this.storageItems = this.getItems();

			if (this.storageItems.length > 0) {
				// console.log(this.storageItems);
				return this.storageItems.some(
					(el) => el.restaurantId == piatto.user_id
				);
			}
			return true;
		},
		log(i) {
			console.log(i);
		},

		setItems(piatto) {
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
						this.storageItems.findIndex(
							(el) => el.id === piatto.id
						) + 1;
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
					'Non puoi aggiungere piatti al carrello di un altro ristorante, proseguendo eliminerai il carrello già esistente'
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
			let i =
				this.storageItems.findIndex(
					(el) => el.id == piatto.id
				) + 1;

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
				img: piatto.image,
			});
		},
		addItems() {
			localStorage.setItem(
				this.storage_key,
				JSON.stringify(this.storageItems)
			);
		},
		getItems() {
			return JSON.parse(
				localStorage.getItem(this.storage_key) || '[]'
			);
		},
	},
};
</script>

<style lang="scss" scoped>
.dishes {
	width: 70%;
}

.order {
	height: 800px;
	position: sticky;
	right: 0;
	top: 50px;
	border-radius: 30px;

	.title {
		font-weight: bold;
		margin: 20px 15px;
	}

	.order--list {
		width: 80%;
		margin: 0 auto;
		height: 500px;
		overflow-y: scroll;

		.order--dish {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin: 10px 0;

			.dish--qnt {
				color: grey;
			}
			.dish--img {
				width: 60px;
				height: 60px;
				border-radius: 10px;
				overflow: hidden;

				img {
					width: 100%;
					height: 100%;
					object-fit: cover;
				}
			}
		}
	}

	.checkout {
		width: 90%;
		margin: 0 auto;
		background-color: #f8b602;
	}
}

@media screen and (max-width: 677px) {
	.order {
		display: none;
		width: 0%;
	}
}

//
@media screen and (max-width: 677px) {
	.order {
		display: none;
		width: 0%;
	}
	.dishes {
		width: 100%;
	}
}
</style>
