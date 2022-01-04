<template>
	<section class="p-3 order">
		<h2 class="title">Order Menù</h2>
		<div class="order--list">
			<div
				class="order--dish"
				v-for="item in storageItems"
				:key="item.id">
				<!-- name & qnt -->
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
			<h2>Total:</h2>
			<h3>$ {{ total }}</h3>
		</div>
		<div>
			<button class="m-3 btn checkout">Check Out</button>
		</div>
	</section>
</template>

<script>
export default {
	data() {
		return {
			storageItems: [],
			storage_key: 'cart_items',
			total: 0,
		};
	},
	created() {
		this.storageItems = this.getItems();
		this.setTotal();
	},
	methods: {
		log(i) {
			console.log(i);
		},
		getItems() {
			return JSON.parse(
				localStorage.getItem(this.storage_key) || '[]'
			);
		},

		setTotal() {
			this.storageItems.forEach((item) => {
				const price = item.price;
				const qnt = item.quantity;

				this.total += price * qnt;
				console.log(this.storageItems);
			});
		},
	},
};
</script>

<style lang="scss" scoped>
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
</style>
