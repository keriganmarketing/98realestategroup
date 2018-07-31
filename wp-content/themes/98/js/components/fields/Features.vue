<template>
    <div>
        <div class="w-full sm:w-1/6 border-right h-auto md:h-10 overflow-hidden">
            <div class="flex h-auto md:h-10 justify-start items-center bg-grey-lighter rounded-t sm:rounded-t-none sm:rounded-l">
                <span class="flex-grow h-auto py-1 px-3 text-grey-darker" >Features</span>
            </div>
        </div>
        <div class="w-full sm:w-auto flex-grow p-0 m-0">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-center flex-wrap px-2">
                <label class="custom-input-container h-auto md:h-10 flex items-center justify-center flex-wrap">
                    <input type="checkbox" name="openHouses" class="radio-input" v-model="openHouses">
                    <span class="input-description checkbox px-1 text-grey-darker">Open Houses</span>
                    <span class="custom-input checkmark"></span>
                </label>
                <label class="custom-input-container h-auto md:h-10 flex items-center justify-center flex-wrap">
                    <input type="checkbox" name="waterFront" class="radio-input" v-model="waterFront">
                    <span class="input-description checkbox px-1 text-grey-darker">Waterfront</span>
                    <span class="custom-input checkmark"></span>
                </label>
                <label class="custom-input-container h-auto md:h-10 flex items-center justify-center flex-wrap">
                    <input type="checkbox" name="pool" class="radio-input" v-model="pool">
                    <span class="input-description checkbox px-1 text-grey-darker">Pool</span>
                    <span class="custom-input checkmark"></span>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            dataOpenHouses: {
                type: Number,
                default: this.openHouses
            },
            dataWaterFront: {
                type: Number,
                default: this.waterFront
            },
            dataPool: {
                type: Number,
                default: this.pool
            },
        },
        data () {
            return {
                openHouses: this.dataOpenHouses,
                waterFront: this.dataWaterFront,
                pool: this.dataPool
            }
        }
    }
</script>