<template>
	<section class="restaurants m-3">
		<div class="row">
			<div
				class="col-lg-4 col-md-6 col-12 restaurant--box"
				v-for="user in users"
				:key="user.id">
				<div class="img--box">
					<img :src="user.image" alt="" />
				</div>
				<div class="justify-content-between info">
					<h4 class="m-0">
						<a :href="`guest/user/${user.id}`">{{ user.name }}</a>
					</h4>
					<div>
						<span
							v-for="type in user.types"
							:key="type.id"
							class="mr-3 type"
							>{{ type.name }}
						</span>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
export default {
	props: ['users'],
};
</script>

<style lang="scss" scoped>
.restaurants {
	.restaurant--box {
		border-radius: 20px;

		h4 {
			a {
				text-decoration: none;
				color: #ff8000;

				&:hover {
					text-decoration: underline;
				}
			}
		}

		.img--box {
			width: 100%;
			aspect-ratio: 1/0.8;
			border-radius: 20px;
			overflow: hidden;

			img {
				width: 100%;
				height: 100%;
				object-fit: cover;
			}
		}

		.type {
			color: #ff80007a;
		}
	}
}
</style>
