<template>
    <span>
        <a v-if="isFavData && !iconOnly" class="btn btn-primary" @click="removeFavorite">
            <img src="/wp-content/themes/98/img/stared.svg" alt="remove from favorites" style="width: 20px; vertical-align: sub; margin: 0 3px 0 0;"> 
            Remove from favorites
        </a>
        <a v-if="!isFavData && !iconOnly" class="btn btn-danger" @click="addFavorite">
            <img src="/wp-content/themes/98/img/star.svg" alt="save to favorites" style="width: 20px; vertical-align: sub; margin: 0 3px 0 0;"> 
            Save to favorites
        </a>
        <a v-if="isFavData && iconOnly" class="favorite active" @click="removeFavorite" >
            <img src="/wp-content/themes/98/img/stared.svg" alt="remove from favorites" > 
        </a>
        <a v-if="!isFavData && iconOnly" class="favorite" @click="addFavorite">
            <img src="/wp-content/themes/98/img/star.svg" alt="save to favorites" > 
        </a>
    </span>
</template>

<script>
export default {
    props: [ 'isFav','mlsNumber','userId','iconOnly'],

    data(){
        return {
            isFavData: false,
            isIconOnly: true
        }
    },

    mounted(){
        this.isFavData = (this.isFav === 1 ? true : false);
        this.isIconOnly = this.iconOnly;
    },

    methods: {

        addFavorite(){

            if(this.userId === 0){
                window.location = '/register/';
            }

            axios.post("/wp-json/kerigansolutions/v1/add-favorite?mls=" + this.mlsNumber + "&userid=" + this.userId )
                .then(response => {
                    this.isFavData = true;
                });
            
        },

        removeFavorite(){

            axios.post("/wp-json/kerigansolutions/v1/delete-favorite?mls=" + this.mlsNumber + "&userid=" + this.userId )
                .then(response => {
                    this.isFavData = false;
                });

        }

    }

}
</script>