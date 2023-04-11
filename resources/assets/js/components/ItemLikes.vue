<template>
    <div>
        <span>{{ likesCounts }}</span>
        <a href="#" v-if="isLiked" @click.prevent="unLike(itemSlug)">
            <i class="glyphicon glyphicon-heart" data-toggle="tooltip" data-placement="bottom" data-original-title="Отменить лайк"></i>
        </a>
        <a href="#" v-else @click.prevent="like(itemSlug)">
            <i class="glyphicon glyphicon-heart-empty" data-toggle="tooltip" data-placement="bottom" data-original-title="Нравится"></i>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['itemSlug', 'liked', 'likeCount'],

        data () {
            return {
                isLiked: '',
                likesCount: null,
            }
        },

        mounted() {
            this.isLiked = this.liked ? true : false;
            this.likesCount = this.likeCount;
        },

        computed: {
            likesCounts: function () {
                return this.likesCount > 0 ? this.likesCount : '';
            }
        },

        methods: {
            like(itemSlug) {
                axios.post('/item/' + itemSlug + '/like')
                    .then((response) => {
                        this.isLiked = true;
                        this.likesCount++;
                    })
                    .catch(response => console.log(response.data));
            },

            unLike(itemSlug) {
                axios.post('/item/' + itemSlug + '/unlike')
                    .then((response) => {
                        this.isLiked = false;
                        this.likesCount--;
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
        margin-right: 2px;
    }

    span {
        font-size: 14px;
    }

    i {
        font-size: 17px;
        top: 3px;
    }
    a {
        color: #d82f49;
        opacity: 0.7;
    }
    a:hover {
        color: #d82f49;
        opacity: 1;
    }
</style>