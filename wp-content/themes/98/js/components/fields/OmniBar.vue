<template>
<on-click-outside :do="close">
    <div class="search-select" :class="{ 'is-active': isOpen }">
        <label>Keyword</label>
        <button
            ref="button"
            @click="open"
            type="button"
            class="search-select-input"
        >
            <span v-if="value !== null">{{ value }}</span>
            <span v-else class="search-select-placeholder">Address / MLS# / Community</span>
        </button>
        <div ref="dropdown" v-show="isOpen" class="search-select-dropdown">
            <input
                ref="search"
                class="search-select-search"
                name="omni"
                v-model="search"
                @keydown.esc="close"

            >
            <ul ref="options" v-show="filteredOptions.length > 0" class="search-select-options">
                <li
                    class="search-select-option"
                    v-for="(option, i) in filteredOptions"
                    :key="option.id"
                    @click="select(option)"
                >
                {{ option }}
                </li>
            </ul>
        <div
            v-show="filteredOptions.length === 0"
            class="search-select-empty">No results found for {{ search }}</div>
        </div>
    </div>
</on-click-outside>
</template>

<script>
import OnClickOutside from './OnClickOutside.vue';
export default {
    components: {
        OnClickOutsidee
    },
    props: ['value', 'options', 'filterFunction'],
    data() {
        return {
            isOpen: false,
            search: '',
        }
    },
    computed : {
        filteredOptions() {
            return this.filterFunction(this.search, this.options)
        }
    },
    methods: {
        open() {
            this.isOpen = true
            this.$nextTick(() => {
                this.$refs.search.focus()
            })
        },
        close() {
            if (! this.isOpen) return
            this.isOpen = false
            this.$refs.button.focus();
        },
        select(option) {
            this.$emit('input', option)
            this.search = ''
            this.close()
        }
    }
}
</script>

<style scoped>
.search-select {
    position: relative;
}
.search-select-input {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    text-align: left;
    display: block;
    width: 100%;
    border-width: 1px;
    padding: 0.5rem 0.75rem;
    background-color: #fff;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
.search-select-input:focus {
  outline: 0;
  -webkit-box-shadow: 0 0 0 3px rgba(52, 144, 220, 0.5);
  box-shadow: 0 0 0 3px rgba(52, 144, 220, 0.5);
}
.search-select-placeholder {
  color: #8795a1;
}
.search-select.is-active .search-select-input {
  -webkit-box-shadow: 0 0 0 3px rgba(52, 144, 220, 0.5);
  box-shadow: 0 0 0 3px rgba(52, 144, 220, 0.5);
}
.search-select-dropdown {
  margin: 0.25rem;
  position: absolute;
  right: 0;
  left: 0;
  background-color: #fff;
  padding: 0.5rem;
  -webkit-box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
  z-index: 50;
}
.search-select-search {
  display: block;
  margin-bottom: 0.5rem;
  width: 100%;
  padding: 0.5rem 0.75rem;
  background-color: #fff;
  color: #2A2D2E;
  border-radius: 0.25rem;
}
.search-select-search:focus {
  outline: 0;
}
.search-select-options {
  list-style: none;
  padding: 0;
  position: relative;
  overflow-y: auto;
  -webkit-overflow-scrolling: touch;
  max-height: 14rem;
}
.search-select-option {
  padding: 0.5rem 0.75rem;
  color: #2A2D2E;
  cursor: pointer;
  border-radius: 0.25rem;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.search-select-option:hover {
  background-color: #432021;
  color: #fff;
}
.search-select-option.is-active,
.search-select-option.is-active:hover {
  background-color: #432021;
  color: #fff;
}
.search-select-empty {
  padding: 0.5rem 0.75rem;
  color: #b8c2cc;
}
</style>

