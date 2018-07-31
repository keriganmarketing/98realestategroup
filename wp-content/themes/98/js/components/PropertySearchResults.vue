<template>
    <div>
        <div class="grid-container">
            <div class="container mx-auto">
                <transition-group
                    tag="div"
                    name="list"
                    mode="out-in"
                    class="w-full flex flex-wrap justify-center items-start min-h-full"
                >
                    {{listing.id}}
                </transition-group>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        searchResults: {
            type: Object,
            default: this.searchResults
        }
    }
}
</script>

<style>
.list-enter-active, .list-leave-active {
  transition: all 0.2s;
}
.list-enter, .list-leave-to /* .list-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: translateY(200px);
}
.list-move {
    transition: transform .2s;
}
</style>

