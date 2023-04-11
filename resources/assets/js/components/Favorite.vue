<template>
    <div>
        <span>{{ favoritesCount }}</span>
        <a href="#" v-if="isFavorited" @click.prevent="unFavorite(itemSlug)">
            <i class="glyphicon glyphicon-star" data-toggle="tooltip" data-placement="bottom" data-original-title="Убрать из избранного"></i>
        </a>
        <a href="#" v-else @click.prevent="favorite(itemSlug)">
            <i class="glyphicon glyphicon-star-empty" data-toggle="tooltip" data-placement="bottom" data-original-title="Добавить в избранное"></i>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['itemSlug', 'favorited', 'favCount'],

        data () {
            return {
                isFavorited: '',
                favsCount: null,
            }
        },

        mounted() {
            this.isFavorited = this.favorited ? true : false;
            this.favsCount = this.favCount;
        },

        computed: {
            favoritesCount: function () {
                return this.favsCount > 0 ? this.favsCount : '';
            }
        },

        methods: {
            favorite(itemSlug) {
                axios.post('/item/' + itemSlug + '/favorite')
                    .then((response) => {
                        this.isFavorited = true;
                        this.favsCount++;
                    })
                    .catch(response => console.log(response.data));
            },

            unFavorite(itemSlug) {
                axios.post('/item/' + itemSlug + '/unfavorite')
                    .then((response) => {
                        this.isFavorited = false;
                        this.favsCount--;
                    })
                    .catch(response => console.log(response.data));
            }
        }
    }
</script>

<style scoped>
    div {
        display: inline-block;
        float: right;
        min-width: 33px;
        text-align: right;
    }

    span {
        font-size: 14px;
    }

    i {
        font-size: 17px;
        top: 3px;
    }

    a {
        color: #ffc042;
        opacity: 0.7;
    }
    a:hover {
        color: #ffc042;
        opacity: 1;
    }
</style>