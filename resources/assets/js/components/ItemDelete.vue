<template>
    <a href="#" :id="'remove-' + itemSlug" class="remove-item" data-toggle="tooltip" data-placement="bottom" data-original-title="Удалить" @click.prevent="destroy(itemSlug)">
        <span class="glyphicon glyphicon-trash"></span>
    </a>
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
            destroy(itemSlug) {
                axios.post('/item/' + itemSlug + '/destroy')
                    .then((response) => {
                        
                        document.getElementById('remove-' + this.slug).style.display = 'none';
                        document.getElementById('cover-' + this.slug).style.display = 'block';
                        document.getElementById('restore-' + this.slug).style.display = 'inline-block';
                        //document.getElementById('restore-1').style.opacity = 1;
                    })
                    .catch(response => console.log(response.data));
            }
            
        }
    }
</script>