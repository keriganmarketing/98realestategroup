<template>
    <div>
        <input
            v-model="omni"
            @click="showResults=true"
            @focus="onFocus"
            @keydown.tab="tabPressed"
            @blur="onBlur()"
            name="omni"
            type="text"
            autocomplete="new-omni"
            placeholder="City, address, subdivision or zip"
            :class="{
                'omni-input-open': showResults == true,
                'omni-input-closed': showResults == false
            }"
            class="text-grey-darkest px-3 py-2 h-10 w-full shadow block"
        >

        <div
            v-if="showResults"
            :class="{
                'omni-results-open': showResults == true,
                'omni-results-closed': showResults == false,
                'h-10': results.length < 2,
                'h-48': results.length > 1
            }"
            class="block shadow w-full border z-50 absolute text-grey-darker hover:border-grey bg-white overflow-hidden overflow-y-scroll"
        >
            <ul class="list-reset mb-px">
                <li v-for="result in results" :key="result.text">
                    <strong><span class="block px-2 py-2">{{ result.text }}</span></strong>
                    <ul class="list-reset mb-2">
                        <li
                            class="hover:bg-teal hover:text-white cursor-pointer px-4 py-2"
                            v-for="child in result.children"
                            :key="child.id"
                            @click="onResultsClick(child.text)"
                            @mousedown.prevent="onBlur"
                        >
                            <span class="block">{{ child.text }}</span>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</template>

<script>
class Results {
    constructor () {
        this.results = {
            text: 'Start typing to begin searching...'
        }
    }
}

export default {
    props: {
        fieldValue: {
            type: String,
            default: this.fieldValue
        }
    },
    data () {
        return {
            omni: this.fieldValue,
            results: new Results,
            showResults: false
        }
    },
    watch: {
        omni: function (newOmni, oldOmni) {
            if (newOmni.length == 0) {
                this.results = new Results;
            } else {
                this.search();
            }
        }
    },
    methods: {
        search: _.debounce(
            function () {
                let vm = this;
                let config = {
                    method: 'get',
                    url: 'https://mothership.kerigan.com/api/v1/omnibar?search=' + this.omni,
                };

                this.results = [
                    {text: 'Searching...'}
                ];
                axios(config)
                    .then(response => {
                        vm.results = response.data.results;
                    })
            },
            250
        ),
        onFocus () {
            this.showResults = true;
        },
        onResultsClick(value) {
            this.omni = value;
            this.showResults = false;
        },
        onBlur() {
            let vm = this;
            setTimeout(function(){
                vm.showResults = false;
            }, 200);
        },
        tabPressed () {
            this.omni = this.results[0].children[0].text;
        }
    }
}
</script>
