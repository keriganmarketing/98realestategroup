<template>
    <div 
        class="embed-responsive embed-responsive-16by9 main-image"
        v-lazy:background-image="url"
        :style="
            'background-size: ' + size + ';'
        "
    >
        <slot></slot>
    </div>
</template>
<script>
export default {
    props: ['src', 'alt'],
    data() {
        return {
            url: {
                src: this.src,
                error: '/wp-content/themes/98/img/nophoto.jpg',
                loading: '/wp-content/themes/98/img/loading.svg',
            },
            size: 'auto'
        }
    }
}
</script>


