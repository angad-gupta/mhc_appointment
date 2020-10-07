<template>


    <div class="row">


        <div class="col-md-3">
            <div class="form-group inspection">
                <label>Chief Complains
                    <span @click="modals.open1 = true;"><i class="fa fa-expand" aria-hidden="true"></i></span>
                </label>
                <textarea v-model="inspection.chief_complains" cols="30" rows="3" class="form-control"></textarea>
                <PrescriptionHelperModel
                        :open="modals.open1"
                        v-on:hide="hideModal"
                        v-on:changeValue="updateCC"
                        :value="inspection.chief_complains">
                </PrescriptionHelperModel>
            </div>
            <div class="form-group inspection">
                <label>On Examinations <span @click="modals.open2 = true"><i class="fa fa-expand"
                                                                             aria-hidden="true"></i></span></label>
                <textarea v-model="inspection.on_examinations" cols="30" rows="3" class="form-control"></textarea>
                <PrescriptionHelperModel
                        :open="modals.open2"
                        v-on:hide="hideModal"
                        v-on:changeValue="updateOE"
                        :value="inspection.on_examinations">
                </PrescriptionHelperModel>
            </div>
            <div class="form-group inspection">
                <label>Provisional Diagnosis <span @click="modals.open3 = true"><i class="fa fa-expand"
                                                                                   aria-hidden="true"></i></span></label>
                <textarea v-model="inspection.provisional_diagnosis" cols="30" rows="3" class="form-control"></textarea>
                <PrescriptionHelperModel
                        :open="modals.open3"
                        v-on:hide="hideModal"
                        v-on:changeValue="updatePD"
                        :value="inspection.provisional_diagnosis">
                </PrescriptionHelperModel>
            </div>
            <div class="form-group inspection">
                <label>Differential Diagnosis <span @click="modals.open4 = true"><i class="fa fa-expand"
                                                                                    aria-hidden="true"></i></span></label>
                <textarea v-model="inspection.differential_diagnosis" cols="30" rows="3"
                          class="form-control"></textarea>
                <PrescriptionHelperModel
                        :open="modals.open4"
                        v-on:hide="hideModal"
                        v-on:changeValue="updateDD"
                        :value="inspection.differential_diagnosis">
                </PrescriptionHelperModel>
            </div>
            <div class="form-group inspection">
                <label>Lab Workup <span @click="modals.open5 = true"><i class="fa fa-expand"
                                                                        aria-hidden="true"></i></span></label>
                <textarea v-model="inspection.lab_workup" cols="30" rows="3" class="form-control"></textarea>
                <PrescriptionHelperModel
                        :open="modals.open5"
                        v-on:hide="hideModal"
                        v-on:changeValue="updateLW"
                        :value="inspection.lab_workup">
                </PrescriptionHelperModel>
            </div>
            <div class="form-group inspection">
                <label>Advices <span @click="modals.open6 = true"><i class="fa fa-expand" aria-hidden="true"></i></span></label>
                <textarea v-model="inspection.advices" cols="30" rows="3" class="form-control"></textarea>
                <PrescriptionHelperModel
                        :open="modals.open6"
                        v-on:hide="hideModal"
                        v-on:changeValue="updateAdvices"
                        :value="inspection.advices">
                </PrescriptionHelperModel>
            </div>

        </div>


        <div class="col-md-7">
            <h2>Rx</h2>
            <div class="medicine-block" v-for="(drug_block,index) in drugBlocks ">
                <span class="badge">{{ index + 1 }}</span>
                <button @click="deleteDrugBlock(index)" class="btn btn-danger"><i class="fa fa-ban"></i></button>

                <div class="row">
                    <div class="col-md-2">
                        <input type="text" :id="'type'+index" class="form-control" placeholder="Type"
                               autocomplete="off">
                        <typeahead v-model="drug_block.type" :target="'#type'+index"
                                   async-src="/typeahead/drug-type?keyword="/>
                    </div>
                    <div class="col-md-4 ">
                        <input type="text" :id="'trade_name'+index" class="form-control" v-model="drug_block.name"
                               placeholder="Drug Name" autocomplete="off">
                        <typeahead v-model="drug_block.name" :target="'#trade_name'+index" :data="drugs"/>
                    </div>
                    <div class="col-md-3">
                        <input type="text" :id="'strength'+index" class="form-control" placeholder="Drug Strength"
                               autocomplete="off">
                        <typeahead v-model="drug_block.strength" :target="'#strength'+index"
                                   async-src="/typeahead/drug-strength?keyword="/>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" :id="'dose'+index" placeholder="Drug Dose"
                               autocomplete="off">
                        <typeahead v-model="drug_block.dose" :target="'#dose'+index"
                                   async-src="/typeahead/drug-dose?keyword="/>
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control" :id="'advice'+index" placeholder="Advice"
                               autocomplete="off">
                        <typeahead v-model="drug_block.advice" :target="'#advice'+index"
                                   async-src="/typeahead/drug-advice?keyword="/>
                    </div>

                </div>
            </div>

            <button class="btn btn-success" @click="newDrugBlock()"><i class="fa fa-plus"></i></button>
        </div>


        <div class="col-md-2">

            <div class="form-group">
                <label for="">Template Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" v-model="template.name">
            </div>
            <div class="form-group"><label for="">Template Description</label>
                <textarea v-model="template.description" id="" cols="30" rows="3" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Prescription Template</label>
                <input type="text" v-model="searchTemplate" class="form-control" placeholder="Search template">
                <ul class="list-group custom-height">
                    <li v-for="prescriptionTemplate in templateFilter" class="list-group-item">
                        <span @click="generateTemplateFromTemplate(prescriptionTemplate.id)">{{prescriptionTemplate.name }}</span>
                        <span @click="openPrintPopUp(prescriptionTemplate.encrypted_id)"
                              class="pull-right text-success"><i class="fa fa-print"></i></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-12">
            <div class="btn-group pull-right" role="group" aria-label="...">
                <button type="button" @click="resetPrescription()" class="btn btn-danger">Reset</button>
                <button type="button" @click="savePrescription()" class="btn btn-success">Save Prescription Template
                </button>
            </div>
        </div>

    </div>

</template>

<script>

    import PrescriptionHelperModel from './PrescriptionHelper';

    export default {
        name: "PrescriptionTemplateComponent",
        components: {
            PrescriptionHelperModel
        },
        props: {
            doctor_id: Number
        },
        data() {
            return {
                prescriptionTemplates: [],
                drugBlocks: [],
                prescriptions: [],
                drugBlock: {name: '', type: '', dose: '', strength: '', advice: ''},
                inspection: {
                    chief_complains: '',
                    on_examinations: '',
                    provisional_diagnosis: '',
                    differential_diagnosis: '',
                    lab_workup: '',
                    advices: ''

                },
                modals: {open1: false, open2: false, open3: false, open4: false, open5: false, open6: false,},
                drugs: [],
                template: {
                    name: '',
                    description: '',
                },
                searchTemplate: ''
            }
        },
        computed: {
            templateFilter() {
                if (this.searchTemplate.length > 0) {
                    return this.prescriptionTemplates.filter((template) => {
                        return template.name.toLowerCase().match(this.searchTemplate.toLowerCase());
                    })
                }
                return this.prescriptionTemplates;
            }
        },
        methods: {
            newDrugBlock: function () {
                var block = {
                    name: '', type: '', dose: '', strength: '', advice: ''
                };
                this.drugBlocks.push(block);
            },


            deleteDrugBlock: function (index) {
                this.drugBlocks.splice(index, 1);
                if (this.drugBlocks.length === 0) {
                    this.drugBlocks.push({
                        name: '', type: '', dose: '', strength: '', advice: ''
                    });
                }
            },

            resetPrescription: function () {
                this.inspection.chief_complains = '';
                this.inspection.differential_diagnosis = '';
                this.inspection.lab_workup = '';
                this.inspection.on_examinations = '';
                this.inspection.provisional_diagnosis = '';
                this.inspection.advices = '';
                this.drugBlocks = [];
                this.drugBlocks.push({name: '', type: '', dose: '', strength: '', advice: ''});
                this.template.name = '';
                this.template.description = '';
            },

            savePrescription: function () {
                this.deleteIfDrugBlockEmpty();

                if (this.drugBlocks.length != 0) {
                    if (this.template.name != '') {
                        axios.post('/prescription-template', {
                            drugs: this.drugBlocks,
                            inspection: this.inspection,
                            template: this.template
                        }).then((response) => {
                            this.resetPrescription();
                            this.prescriptionTemplates.push(response.data);

                            this.$confirm({
                                title: 'Prescription template saved!',
                                content: 'You want to print this prescription template ?'
                            }).then(() => {
                                this.openPrintPopUp(response.data.encrypted_id);

                            })

                        }).catch(function (error) {
                            console.error(error)
                        });
                    } else {
                        this.$notify({
                            placement: 'bottom-right',
                            type: 'danger',
                            title: 'Tempalte name is empty!',
                            content: 'Please give a name of your template to save'
                        });
                    }
                } else {

                    this.$notify({
                        placement: 'bottom-right',
                        type: 'danger',
                        title: 'Drug is empty!',
                        content: 'Please enter at-least one drug to save prescription'
                    });

                    var block = {
                        name: '', type: '', dose: '', strength: '', advice: ''
                    };
                    this.drugBlocks.push(block);


                }

            },

            deleteIfDrugBlockEmpty: function () {
                this.drugBlocks.forEach((value, index) => {
                    if (value.type.trim() == '' && value.name.trim() == '' && value.dose.trim() == '' && value.strength.trim() == '' && value.advice.trim() == '') {
                        this.drugBlocks.splice(index, 1);
                        return this.deleteIfDrugBlockEmpty();
                    }
                });
            },

            openPrintPopUp: function (src) {
                let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=0,height=0,left=-1000,top=-1000`;
                window.open('/print/prescription-template/' + src, 'Open', params);
            },

            generateTemplateFromTemplate: function (id) {
                this.$confirm({
                    title: 'Generate Prescription Template!',
                    content: 'Click Ok if you want to generate prescription template from this prescription template.'
                }).then(() => {
                    axios.get('/vue/my-template-by-id/' + id).then((response) => {
                        console.log(response.data);
                        this.drugBlocks = response.data.drugs;
                        this.inspection = response.data.inspection;
                        this.template.name = response.data.name;
                        this.template.description = response.data.description;
                    })
                });


            },

            hideModal: function (value) {
                this.modals.open1 = false;
                this.modals.open2 = false;
                this.modals.open3 = false;
                this.modals.open4 = false;
                this.modals.open5 = false;
                this.modals.open6 = false;
            },

            updateCC: function (value) {
                this.inspection.chief_complains = value;
                // console.log(value);
            },

            updateOE: function (value) {
                this.inspection.on_examinations = value;
            },

            updatePD: function (value) {
                this.inspection.provisional_diagnosis = value;
            },

            updateDD: function (value) {
                this.inspection.differential_diagnosis = value;
            },

            updateLW: function (value) {
                this.inspection.lab_workup = value;
            },

            updateAdvices: function (value) {
                this.inspection.advices = value;
            },


        },
        beforeMount() {
            this.drugBlocks.push(this.drugBlock);

            axios.get('/vue/my-templates').then((response) => {
                this.prescriptionTemplates = response.data;
            })
        },
        mounted() {
            axios.get('/vue/drug-by-doctor-department').then((response) => {
                console.log(response);
                this.drugs = response.data;
            });
        },


    }
</script>

<style scoped>

    .autocomplete {
        position: relative;
    }

    .autocomplete .list-group {
        position: absolute;
        top: 32px;
        left: 0;
        z-index: 10;
        display: none;
        cursor: pointer;
    }


    .inspection label {
        position: relative;
        width: 100%;
    }

    .inspection label > span {
        position: absolute;
        top: 0;
        right: 0;
        cursor: pointer;
        padding: 0px 10px;
    }

    .custom-height {
        max-height: 250px;
        overflow-y: scroll;
    }

    .custom-height li {
        cursor: pointer;
    }


</style>