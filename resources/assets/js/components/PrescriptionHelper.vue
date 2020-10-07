<template>


    <modal v-model="modalStatus" title="Modal Title" size="lg" :backdrop="false">
        <div class="row">
            <div class="col-md-5">
                    <textarea ref="modalInput" id="modelInput" v-model="values" class="form-control" cols="30"
                              autofocus="true"
                              rows="10"></textarea>
            </div>
            <div class="col-md-7">
                <div class="input-group">
                    <input type="text" v-model="search.text" class="form-control" aria-label="...">
                    <span class="input-group-btn">
                        <!--<input type="text" v-model="search.id" class="form-control" style="width: 150px">-->
                        <select v-model="search.id" class="form-control" style="width: 150px">
                        <option value="0">All</option>
                        <option value="1">Chief Complains</option>
                        <option value="2">On Examinations</option>
                        <option value="3">Provisional Diagnosis</option>
                        <option value="4">Differential Diagnosis</option>
                        <option value="5">Lab Workup</option>
                        <option value="6">Advices</option>
                        </select>
                        </span>
                </div>
                <div class="flex-container">
                    <div v-for="(helper, index) in computedHelper" @click="addValue(helper.helper_text)">
                        {{helper.helper_text }}
                    </div>
                </div>
            </div>
        </div>

        <div slot="footer">
            <btn @click="modalStatus = false">Close</btn>
        </div>

    </modal>


</template>

<script>
    export default {

        props: {
            open: Boolean,
            value: String
        },

        data: function () {
            return {
                nV: this.values,
                helpers: '',
                search: {
                    text: '',
                    id: ''
                },
                modal: this.open
            }
        },

        methods: {
            hide: function () {
                this.$emit('hide');
            },

            addValue: function (value) {
                let textarea = this.$refs.modalInput;
                let currentCursorPosition = this.$refs.modalInput.selectionStart;
                let textBefore = textarea.value.substring(0,currentCursorPosition);
                let textAfter = textarea.value.substring(currentCursorPosition,textarea.value.length);
                textarea.value = textBefore + value + textAfter;
                this.values = this.$refs.modalInput.value;
                textarea.selectionEnd = currentCursorPosition + value.length;
                textarea.focus();
            }

        },

        computed: {
            values: {
                get: function () {
                    this.nV = this.value;
                    return this.nV;
                },

                set: function (newValue) {
                    this.$emit('changeValue', newValue);
                    // this.nV = newValue;
                }
            },

            modalStatus: {
                get: function () {
                    return this.open;
                },

                set: function (newModalStatus) {
                    this.$emit('hide', newModalStatus);
                }
            },

            computedHelper() {

                if (this.search.text.length > 0) {
                    if (this.search.id == 0) {
                        return this.helpers.filter((helper) => {
                            return helper.helper_text.toLowerCase().match(this.search.text.toLowerCase());
                        })
                    } else {
                        return this.helpers.filter((helper) => {
                            return helper.helper_text.toLowerCase().match(this.search.text.toLowerCase()) && helper.category == this.search.id;
                        })
                    }
                }

                if (this.search.text.length == 0 && this.search.id != '') {
                    return this.helpers.filter((helper) => {
                        return helper.category == this.search.id;
                    })
                }

                return this.helpers;

            }
        },

        mounted() {
            axios.get('/vue/get-all-helpers').then((response) => {
                this.helpers = response.data;
                // console.log(response.data);
            })
        }

    }
</script>

<style scoped>
    .flex-container {
        display: flex;
        flex-wrap: wrap;
        max-height: 350px;
        overflow-y: scroll;
    }

    .flex-container div {
        padding: 5px 10px;
        border: 1px solid #cacaca;
        cursor: pointer;
    }
</style>