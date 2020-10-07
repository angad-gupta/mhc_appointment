<template>
    <div class="row">
        <div class="col-xs-6">
            <h4>All Doctor</h4>
            <input type="text" class="form-control" placeholder="Search Doctor">

            <div class="doctors">
                <div class="media doctor-media-list" v-for="(detached_doctor, index) in detached_doctors"
                     @click="appendDoctor(index)">
                    <div class="media-left">
                        <img src="https://hcplive.s3.amazonaws.com/v1_media/_image/happydoctor.jpg" height="60px">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">{{ detached_doctor.title }} {{ detached_doctor.full_name }}</h4>
                        <p>{{ detached_doctor.department.title }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <h4>Appended Doctor</h4>
            <input type="text" class="form-control" placeholder="Search Doctor">
            <div class="doctors">
                <div class="media doctor-media-list" v-for="appended_doctor in appended_doctors">
                    <div class="media-left">
                        <img src="https://hcplive.s3.amazonaws.com/v1_media/_image/happydoctor.jpg" height="60px">
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">{{ appended_doctor.title }} {{ appended_doctor.full_name }}</h4>
                        <p>{{ appended_doctor.department.title }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PatientReeferComponent",
        props: {
            patient_id: Number
        },
        data() {
            return {
                appended_doctors: [],
                detached_doctors: [],
            }
        },

        methods: {
            appendDoctor: function (index) {
                this.$confirm({
                    title: 'Reefer patient to this doctor ?',
                    content: 'CLick OK to confirm'
                }).then(() => {
                    axios.post('/patient-reefer', {
                        doctor_id: this.detached_doctors[index].id,
                        patient_id: this.patient_id
                    }).then((response) => {
                        console.log(response);
                        this.appended_doctors.push(this.detached_doctors[index]);
                        this.detached_doctors.splice(index, 1);
                        this.$notify({
                            placement: 'bottom-right',
                            type: 'success',
                            title: 'Reefer patient successfully!',
                            content: 'Reefer patient successfully'
                        });
                    })

                })
            }
        },
        mounted() {
            axios.get('/vue/appended-doctor/' + this.patient_id).then((response) => {
                this.appended_doctors = response.data;
                console.log(response.data);
            });

            axios.get('/vue/detached-doctor/' + this.patient_id).then((response) => {
                this.detached_doctors = response.data;
                console.log(response.data);
            })
        }
    }
</script>

<style scoped>

</style>