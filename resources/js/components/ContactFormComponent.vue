<template>
    <div class="col-lg-5 d-flex flex-column text-center bg-dark-2">
        <div class="container my-auto py-5 pt-lg-4 pb-lg-2">
            <div class="row mx-0">
                <div class="col-11 col-lg-10 mx-auto">
                    <h3 class="mb-3 text-white fw-600">Get a free gift at launch</h3>
                    <p class="text-white-50 mb-4">
                        Provide your contact details and we will send you a free gift when we launch!
                    </p>

                    <!-- Contact Form -->
                    <form id="contact-form" class="form-dark" @submit.prevent="save" method="post">
                        <div class="mb-3">
                            <input id="name"
                                   v-model="formData.name"
                                   type="text"
                                   class="form-control border-2"
                                   :class="{'is-invalid': Array.isArray(errors['name'] )}"
                                   placeholder="Enter Your Name"
                                   required>
                            <div class="pt-1">
                                <p class="text-sm-start text-danger" v-if="Array.isArray(errors['name'] )">
                                    {{ errors['name'][0] }}
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input id="email"
                                   v-model="formData.email"
                                   type="email"
                                   class="form-control border-2"
                                   :class="{'is-invalid': Array.isArray(errors['email'] )}"
                                   placeholder="Enter Your Email"
                                   required>
                            <div class="pt-1" v-if="Array.isArray(errors['email'] )">
                                <p class="text-sm-start text-danger">
                                    {{ errors['email'][0] }}
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input id="phone"
                                   v-model="formData.phone"
                                   type="tel"
                                   class="form-control border-2"
                                   :class="{'is-invalid': Array.isArray(errors['phone'] )}"
                                   placeholder="Enter Your Phone Number"
                                   required>
                            <div class="pt-1" v-if="Array.isArray(errors['phone'] )">
                                <p class="text-sm-start text-danger">
                                    {{ errors['phone'][0] }}
                                </p>
                            </div>
                        </div>
                        <fieldset>
                            <div class="row px-0 py-0">
                                <div class="mb-3 col-3">
                                    <input v-model="formData.address.number"
                                           type="text"
                                           class="form-control border-2"
                                           :class="{'is-invalid': Array.isArray(errors['address.number'] )}"
                                           placeholder="House No."
                                           required>
                                </div>
                                <div class="mb-3 col-9">
                                    <input id="street"
                                           v-model="formData.address.street"
                                           type="text"
                                           class="form-control border-2"
                                           :class="{'is-invalid': Array.isArray(errors['address.street'] )}"
                                           placeholder="Street Name"
                                           required>
                                </div>
                                <div class="col-12 pt-1" v-if="Array.isArray(errors['address.number'] )">
                                    <p class="text-sm-start text-danger">
                                        {{ (errors['address.number'][0]).replace('address.number', 'house number') }}
                                    </p>
                                </div>
                                <div class="col-12 pt-1" v-if="Array.isArray(errors['address.street'] )">
                                    <p class="text-sm-start text-danger">
                                        {{ (errors['address.street'][0]).replace('address.street', 'street name') }}
                                    </p>
                                </div>
                                <div class="mb-3 col-4">
                                    <CountryFormComponent :required="true"
                                                          @change="handleChangeCountry"
                                                          v-model="formData.address.country">
                                    </CountryFormComponent>
                                    <div class="pt-1" v-if="Array.isArray(errors['address.country'] )">
                                        <p class="text-sm-start text-danger">
                                            {{ (errors['address.country'][0]).replace('address.country', 'country') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3 col-8">
                                    <select v-model="formData.address.state"
                                            v-if="useStateDropdown"
                                            class="form-control border-2"
                                            required>
                                        <option value="">
                                            {{ requesting.state ? "Loading...":"--Select State/Province" }}
                                        </option>
                                        <option :key="state.abbreviation" v-for="state in stateList"
                                                :value="state.name">{{ state.name }}
                                        </option>
                                    </select>

                                    <input v-model="formData.address.state"
                                           v-else
                                           type="text"
                                           class="form-control border-2"
                                           :class="{'is-invalid': Array.isArray(errors['address.state'] )}"
                                           placeholder="State/Province"
                                           required>

                                    <div class="pt-1" v-if="Array.isArray(errors['address.state'] )">
                                        <p class="text-sm-start text-danger">
                                            {{ (errors['address.state'][0]).replace('address.state', 'state/province') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3 col-12">
                                    <input v-model="formData.address.city"
                                           type="text"
                                           class="form-control border-2"
                                           :class="{'is-invalid': Array.isArray(errors['address.city'] )}"
                                           placeholder="City"
                                           required>
                                    <div class="pt-1" v-if="Array.isArray(errors['address.city'] )">
                                        <p class="text-sm-start text-danger">
                                            {{ (errors['address.city'][0]).replace('address.city', 'city') }}
                                        </p>
                                    </div>
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
    import 'vue-toast-notification/dist/theme-sugar.css';

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
                errors: {}
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
                        _vm.requesting.state = false;
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

                    _vm.errors = {};

                    if (response.data.success === true) {
                        _vm.showToast('Submitted successfully!');
                    } else {
                        _vm.showToast('An error occurred!', 'error')
                    }
                } catch (err) {
                    if (err.response && err.response.data) {
                        const { data } = err.response;

                        if (data.errors) {
                            _vm.errors = data.errors;
                        }

                        _vm.showToast(data.error, 'error');
                    }
                } finally {
                    _vm.requesting.save = false;
                }
            },
            showToast(message, type) {
                Vue.$toast.open({
                    message: message,
                    type: type === undefined ? 'success' : type,
                    position: 'top-right'
                });
            }
        }
	}
</script>

<style scoped>

</style>
