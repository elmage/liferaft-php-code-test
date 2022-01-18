<template>
    <div class="col-lg-5 d-flex flex-column text-center bg-dark-2">
        <div class="container my-auto py-5 pt-lg-4 pb-lg-2">
            <div class="row mx-0">
                <div class="col-11 col-lg-10 mx-auto">
                    <h3 class="mb-3 text-white fw-600">Contact Us</h3>
                    <p class="text-white-50 mb-4">We launch our new website soon. For Customer Support and Query, Send us a note.</p>

                    <!-- Contact Form -->
                    <form id="contact-form" class="form-dark" @submit="save" method="post">
                        <div class="mb-3">
                            <input id="name" v-model="formData.name" type="text" class="form-control border-2" placeholder="Enter Your Name" required >
                        </div>
                        <div class="mb-3">
                            <input id="email" v-model="formData.email" type="email" class="form-control border-2" placeholder="Enter Your Email" required >
                        </div>
                        <div class="mb-3">
                            <input id="phone" v-model="formData.phone" type="tel" class="form-control border-2" placeholder="Enter Your Phone Number" required >
                        </div>
                        <fieldset>
                            <div class="row px-0 py-0">
                                <div class="mb-3 col-3">
                                    <input id="houseNumber" v-model="formData.address.number" type="text" class="form-control border-2" placeholder="House No." required >
                                </div>
                                <div class="mb-3 col-9">
                                    <input id="street" v-model="formData.address.street" type="text" class="form-control border-2" placeholder="Street Name" required >
                                </div>
                                <div class="mb-3 col-4">
                                    <CountryFormComponent :required="true" @change="handleChangeCountry" v-model="formData.address.country"></CountryFormComponent>
                                </div>
                                <div class="mb-3 col-8">
                                    <select v-model="formData.address.state" v-if="useStateDropdown" class="form-control border-2" required>
                                        <option value="">{{ requesting.state ? "Loading...":"--Select State/Province" }}</option>
                                        <option :key="state.abbreviation" v-for="state in stateList" :value="state.name">{{ state.name }}</option>
                                    </select>
                                    <input v-model="formData.address.state" v-else type="text" class="form-control border-2" placeholder="State/Province" required >
                                </div>
                                <div class="mb-3 col-12">
                                    <input id="city" v-model="formData.address.city" type="text" class="form-control border-2" placeholder="City" required >
                                </div>
                            </div>
                        </fieldset>
                        <div class="d-grid mt-4">
                            <button id="submit-btn" class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="container">
            <p class="text-2 text-light mb-2">Copyright © 2022 <a href="#">LifeRaft</a>. All Rights Reserved.</p>
        </footer>
    </div>
</template>

<script>
    import CountryFormComponent from "./FormComponents/CountryFormComponent";

	export default {
		name: "ContactFormComponent",
        components: {
            CountryFormComponent
        },
        data() {
            return {
                formData: {
                    name: '',
                    email: '',
                    phone: '',
                    address: {
                        number: '',
                        street: '',
                        country: '',
                        state: '',
                        city: '',
                    }
                },
                stateList: [],
                requesting: {
                    state: false,
                    save: false
                },
                errors: {},
                errorMessage: ""
            }
        },
        computed: {
            useStateDropdown: function () {
                const cases = ['CAN', 'USA'];
                return cases.includes( this.formData.address.country )
            }
        },
        methods: {
		    async handleChangeCountry(e) {
		        let _vm = this;
		        _vm.formData.address.state = '';

		        if (_vm.useStateDropdown) {
                    const headers = {
                        'Content-type': 'application/json',
                        'Access-Control-Allow-Origin': '*'
                    };

                    _vm.requesting.state = true

                    try {
                        const response = await axios.get(`/api/countries/${_vm.formData.address.country}`, {
                            headers
                        });

                        if (response.data.states !== undefined) {
                            _vm.stateList = response.data.states;
                        }
                    } catch (e) {
                        _vm.address.country = '';
                    } finally {
                        _vm.requesting.state = false
                    }
                }
            },
            async save() {
                let _vm = this;

                _vm.requesting.save = true;

                const headers = {
                    'Content-type': 'application/json',
                };

                try {
                    const response = await axios.post('/contact/submit', _vm.formData, {
                        headers
                    });
                } catch (err) {
                    if (err.response && err.response.data) {
                        const { data } = err.response;

                        _vm.errorMessage = data ? data.message : ''

                        if (data.errors) {
                            _vm.errors = data.errors;
                        }
                    }
                } finally {
                    _vm.requesting.save = false;
                }
            },
        }
	}
</script>

<style scoped>

</style>
