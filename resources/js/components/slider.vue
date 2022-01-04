<template>
	<section class="carosel">
		<div class="slider--img">
			<img src="./img/banner1.jpg" alt="" />
		</div>
		<div class="slider--img">
			<img src="./img/banner2.jpg" alt="" />
		</div>
		<div class="slider--img">
			<img src="./img/banner3.jpg" alt="" />
		</div>
		<div class="slider--img">
			<img src="./img/banner4.jpg" alt="" />
		</div>
		<div class="slider--img">
			<img src="./img/banner5.jpg" alt="" />
		</div>
		<div class="slider--img">
			<img src="./img/banner6.jpg" alt="" />
		</div>

		<div class="dots">
			<div
				v-for="(n, i) in imgs"
				:class="`dot ${idxSlide == i ? 'act' : ''}`"
				:key="i"></div>
		</div>
	</section>
</template>

<script>
export default {
	data() {
		return {
			imgs: [],
			idxSlide: 0,
		};
	},
	mounted() {
		this.slide();
	},

	methods: {
		slide() {
			const imgs = document.querySelectorAll('.slider--img');
			let a = 0;
			this.imgs = imgs;

			imgs.forEach((img, i) => {
				img.style.transform = `translateX(${100 * i + 0}%)`;
			});

			setInterval(() => {
				if (a < 5) a++;
				else a = 0;
				imgs.forEach((img, i) => {
					img.style.transform = `translateX(${100 * (i + -a)}%)`;
					this.idxSlide = a;
				});
			}, 3000);
		},
	},
};
</script>

<style lang="scss" scoped>
.carosel {
	margin: 30px 0;
	display: flex;
	align-items: flex-end;
	justify-content: center;
	position: relative;
	background-color: red;
	height: 350px;
	border-radius: 20px;
	overflow: hidden;

	.slider--img {
		position: absolute;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		transition: all 600ms;
		background-color: green;

		img {
			height: 100%;
			width: 100%;
			object-fit: cover;
		}
	}
}

.dots {
	z-index: 111;
	display: flex;
	background-color: rgba(255, 255, 255, 0.308);
	align-items: flex-end;

	height: fit-content;
	padding: 10px 30px;
	border-top-right-radius: 40px;
	border-top-left-radius: 40px;

	.dot {
		height: 10px;
		margin: 0 7px;
		width: 10px;
		border-radius: 10px;
		background-color: rgba(124, 124, 124, 0.404);
		z-index: 10;
	}
	.act {
		background-color: rgba(197, 197, 197, 0.596);
		transition: 100ms;
	}
}
</style>
