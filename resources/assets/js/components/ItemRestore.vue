<template>
    <div :id="'restore-' + itemSlug" style="display: none;">
        <span>Вещь удалена.</span><br>
        <a href="#" id="restore-1" @click.prevent="restore(itemSlug)">Восстановить</a>
    </div>
</template>

<script>
    export default {
        props: ['itemSlug'],

        data () {
            return {
                slug: this.itemSlug,
            }
        },

        methods: {
            restore(itemSlug) {
                axios.post('/item/' + itemSlug + '/restore')
                    .then((response) => {
                        document.getElementById('restore-' + this.slug).style.display = 'none';
                        document.getElementById('remove-' + this.slug).style.display = 'inline-block';
                        document.getElementById('cover-' + this.slug).style.display = 'none';
                    })
                    .catch(response => console.log(response.data));
            },

            
        }
    }
</script>

<style scoped>
    div {
        /*display: inline-block;*/
        position: absolute;
        top: 45%;
        left: 20px;
        right: 20px;
        z-index: 3;
        padding: 5px;
        background: #f0f0f0;
        border-radius: 3px;
        text-align: center;
        box-shadow: 0 0 3px rgba(0,0,0,0.3);
    }

    span {
        color: #333333;
    }

    a {
        
    }
</style>