<template>
    <div style="position: relative;">
        <Teleport to="body">
            <div v-if="is_loading" class="loading-overlay">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Procesando...</span>
                </div>
                <p class="loading-text mt-3">Procesando, por favor espera...</p>
            </div>
        </Teleport>
        <div class="row">
            <div class="col-12">
                <div v-if="message !== ''" class="mbg-3 alert alert-success alert-dismissible fade show" role="alert">
                    <span class="pe-2">
                        <i class="fa fa-star"></i>
                    </span>
                    {{ message }}
                </div>
            </div>
            <div class="col-md-12 col-xl-6">

                <div v-if="social_security_data">
                    <button @click="editSocialSecurityData" type="button" class="mb-2 btn btn-mh-dark-blue mb-3"><i class="fa fa-edit"></i>  Editar</button>
                    <button @click="deleteSocialSecurity(social_security_data.id)" type="button" class="mb-2 btn btn-danger mb-3 mx-2"><i class="fa fa-trash"></i>  Eliminar</button>
                </div>
                <div v-else>
                    <button @click="addSocialSecurityData" type="button" class="mb-2 btn btn-mh-dark-blue mb-3"><i class="fa fa-plus"></i>  Agregar</button>
                </div>

                <div v-if="social_security_data != null && add_social_security_data === false && edit_social_security_data === false && show_social_security_data === false" class="card-hover-shadow card-border mb-3 card frame-information-card">
                    <div class="card-header">
                        Seguridad Social
                    </div>
                    <div class="card-body">
                        <div class="wrapper-social-bank my-3">
                            <div class="data-pair full-width">
                                <div class="box-label lb-44">
                                    <p class="">Entidad promotora de salud (EPS):</p>
                                </div>
                                <div class="box-value vl-44">
                                    <p class="">{{ social_security_data.eps.name }}</p>
                                </div>
                            </div>
                            <div class="data-pair">
                                <div class="box-label lb-45">
                                    <p class="">Fondo de pensiones:</p>
                                </div>
                                <div class="box-value vl-45">
                                    <p class="">{{ social_security_data.afp_pension.name }}</p>
                                </div>
                            </div>
                            <div class="data-pair">
                                <div class="box-label lb-45">
                                    <p class="">Fondo de cesantías:</p>
                                </div>
                                <div class="box-value vl-45">
                                    <p class="">{{ social_security_data.afp_saving.name }}</p>
                                </div>
                            </div>
                            <div class="data-pair">
                                <div class="box-label lb-45">
                                    <p class="">Administradora de riesgos laborales (ARL):</p>
                                </div>
                                <div class="box-value vl-45">
                                    <p class="">{{ social_security_data.arl.name }}</p>
                                </div>
                            </div>
                            <div class="data-pair">
                                <div class="box-label lb-45">
                                    <p class="">Caja de compensación familiar:</p>
                                </div>
                                <div class="box-value vl-45">
                                    <p class="">{{ social_security_data.ccf.name }}</p>
                                </div>
                            </div>
                            <div class="data-pair full-width">
                                <div class="box-label lb-46">
                                    <p class="">Observaciones:</p>
                                </div>
                                <div class="box-value vl-46">
                                    <p class="">{{ social_security_data.observations }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="social_security_data && (social_security_data.eps_certificate_url || social_security_data.afp_pension_certificate_url || social_security_data.afp_saving_certificate_url)" class="card-footer">
                        <div class="buttons-container">
                            <button v-if="social_security_data.eps_certificate_url" @click="downloadEpsCertificate(social_security_data.id)" class="mr-2 btn-icon btn btn-primary">
                                <font-awesome-icon :icon="['fas', 'download']" /> EPS
                            </button>
                            <button v-if="social_security_data.afp_pension_certificate_url" @click="downloadAfpPensionCertificate(social_security_data.id)" class="mr-2 btn-icon btn btn-primary">
                                <font-awesome-icon :icon="['fas', 'download']" /> Pensiones
                            </button>
                            <button v-if="social_security_data.afp_saving_certificate_url" @click="downloadAfpSavingCertificate(social_security_data.id)" class="mr-2 btn-icon btn btn-primary">
                                <font-awesome-icon :icon="['fas', 'download']" /> Cesantías
                            </button>
                        </div>
                    </div>
                </div>
                <div v-else-if="social_security_data === null && add_social_security_data === true && edit_bank_information_data === false && show_bank_information_data === false">
                    <div class="col-12">
                        <form @submit.prevent="storeSocialSecurityInformation" enctype="multipart/form-data">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Seguridad Social
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="eps_id" class="form-label">EPS*</label>
                                                <select v-model="eps_id" name="eps_id" class="form-control"  id="eps_id">
                                                    <option value="" disabled selected hidden>Seleccionar EPS</option>
                                                    <option v-for="eps_type in eps_types" :value="eps_type.id">{{ eps_type.name }}</option>
                                                </select>
                                                <span v-if="errors_social_security && errors_social_security.eps_id" class="error text-danger" for="eps_id">{{ errors_social_security.eps_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="image" class="form-label">Certificado EPS</label>
                                                <input
                                                    ref="epsFileInput"
                                                    type="file"
                                                    accept=".pdf"
                                                    class="form-control d-none"
                                                    @change="handleEpsFile"
                                                >
                                                <!-- <span v-if="errors_bank_information && errors_bank_information.image" class="error text-danger" for="image">{{ errors_bank_information.image[0] }}</span> -->

                                                <div class="input-group">
                                                    <button type="button" class="btn btn-primary" @click="selectEpsFile">
                                                        <font-awesome-icon :icon="['fas', 'upload']" />
                                                        Seleccionar
                                                    </button>
                                                    <input
                                                        @click="selectEpsFile"
                                                        type="text"
                                                        class="form-control"
                                                        :value="eps_file != '' ? eps_file.name : ''"
                                                        readonly
                                                        placeholder="Ningún archivo seleccionado"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="afp_pension_id" class="form-label">Fondo Pensiones*</label>
                                                <select v-model="afp_pension_id" name="afp_pension_id" class="form-control"  id="afp_pension_id">
                                                    <option value="" disabled selected hidden>Seleccionar AFP</option>
                                                    <option v-for="afp_type in afp_types" :value="afp_type.id">{{ afp_type.name }}</option>
                                                </select>
                                                <span v-if="errors_social_security && errors_social_security.afp_pension_id" class="error text-danger" for="afp_pension_id">{{ errors_social_security.afp_pension_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="image" class="form-label">Certificado fondo de pensiones</label>
                                                <input
                                                    ref="afpPensionFileInput"
                                                    type="file"
                                                    accept=".pdf"
                                                    class="form-control d-none"
                                                    @change="handleAfpPensionFile"
                                                >
                                                <!-- <span v-if="errors_bank_information && errors_bank_information.image" class="error text-danger" for="image">{{ errors_bank_information.image[0] }}</span> -->

                                                <div class="input-group">
                                                    <button type="button" class="btn btn-primary" @click="selectAfpPensionFile">
                                                        <font-awesome-icon :icon="['fas', 'upload']" />
                                                        Seleccionar
                                                    </button>
                                                    <input
                                                        @click="selectAfpPensionFile"
                                                        type="text"
                                                        class="form-control"
                                                        :value="afp_pension_file != '' ? afp_pension_file.name : ''"
                                                        readonly
                                                        placeholder="Ningún archivo seleccionado"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="afp_saving_id" class="form-label">Fondo Cesantías*</label>
                                                <select v-model="afp_saving_id" name="afp_saving_id" class="form-control"  id="afp_saving_id">
                                                    <option value="" disabled selected hidden>Seleccionar AFP</option>
                                                    <option v-for="afp_type in afp_types" :value="afp_type.id">{{ afp_type.name }}</option>
                                                </select>
                                                <span v-if="errors_social_security && errors_social_security.afp_saving_id" class="error text-danger" for="afp_saving_id">{{ errors_social_security.afp_saving_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="image" class="form-label">Certificado fondo de cesantías</label>
                                                <input
                                                    ref="afpSavingFileInput"
                                                    type="file"
                                                    accept=".pdf"
                                                    class="form-control d-none"
                                                    @change="handleAfpSavingFile"
                                                >
                                                <!-- <span v-if="errors_bank_information && errors_bank_information.image" class="error text-danger" for="image">{{ errors_bank_information.image[0] }}</span> -->

                                                <div class="input-group">
                                                    <button type="button" class="btn btn-primary" @click="selectAfpSavingFile">
                                                        <font-awesome-icon :icon="['fas', 'upload']" />
                                                        Seleccionar
                                                    </button>
                                                    <input
                                                        @click="selectAfpSavingFile"
                                                        type="text"
                                                        class="form-control"
                                                        :value="afp_saving_file != '' ? afp_saving_file.name : ''"
                                                        readonly
                                                        placeholder="Ningún archivo seleccionado"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="ccf_id" class="form-label">Caja de compensación familiar*</label>
                                                <select v-model="ccf_id" name="ccf_id" class="form-control"  id="ccf_id">
                                                    <option value="" disabled selected hidden>Seleccionar caja de compensación</option>
                                                    <option v-for="ccf_type in ccf_types" :value="ccf_type.id">{{ ccf_type.name }}</option>
                                                </select>
                                                <span v-if="errors_social_security && errors_social_security.ccf_id" class="error text-danger" for="ccf_id">{{ errors_social_security.ccf_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="arl_id" class="form-label">ARL*</label>
                                                <select v-model="arl_id" name="arl_id" class="form-control"  id="arl_id">
                                                    <option value="" disabled selected hidden>Seleccionar ARL</option>
                                                    <option v-for="arl_type in arl_types" :value="arl_type.id">{{ arl_type.name }}</option>
                                                </select>
                                                <span v-if="errors_social_security && errors_social_security.arl_id" class="error text-danger" for="arl_id">{{ errors_social_security.arl_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="observations_social_security" class="form-label">Observaciones</label>
                                                <textarea v-model="observations_social_security" name="observations_social_security" id="observations_social_security" type="text" class="form-control" placeholder="Ingrese sus observaciones" rows="4" cols="50"></textarea>
                                                <span v-if="errors_social_security && errors_social_security.observations" class="error text-danger" for="observations">{{ errors_social_security.observations[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex">
                                    <!-- Los campos marcados con * son obligatorios. -->
                                    <button type="submit" class="btn btn-primary">Guardar</button>

                                    <button @click="resetSocialSecurity" type="button" class="btn btn-secondary mx-2">Cancelar</button>

                                    <!-- <span class="float-end text-muted" style="font-size: 0.95em;">Los campos marcados con * son obligatorios.</span> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div v-else-if="social_security_data != null && add_social_security_data === false && edit_social_security_data === true && show_social_security_data === false">
                    <div class="col-12">
                        <form @submit.prevent="updateSocialSecurityInformation" enctype="multipart/form-data">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Seguridad Social
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="eps_id" class="form-label">EPS*</label>
                                                <select v-model="social_security_data.eps_id" name="eps_id" class="form-control"  id="eps_id">
                                                    <option value="" disabled selected hidden>Seleccionar EPS</option>
                                                    <option v-for="eps_type in eps_types" :value="eps_type.id">{{ eps_type.name }}</option>
                                                </select>
                                                <span v-if="errors_social_security && errors_social_security.eps_id" class="error text-danger" for="eps_id">{{ errors_social_security.eps_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="image" class="form-label">Certificado EPS</label>
                                                <input
                                                    ref="epsFileInput"
                                                    type="file"
                                                    accept=".pdf"
                                                    class="form-control d-none"
                                                    @change="handleEpsFile"
                                                >
                                                <!-- <span v-if="errors_bank_information && errors_bank_information.image" class="error text-danger" for="image">{{ errors_bank_information.image[0] }}</span> -->

                                                <div class="input-group">
                                                    <button type="button" class="btn btn-primary" @click="selectEpsFile">
                                                        <font-awesome-icon :icon="['fas', 'upload']" />
                                                        Seleccionar
                                                    </button>
                                                    <input
                                                        @click="selectEpsFile"
                                                        type="text"
                                                        class="form-control"
                                                        :value="eps_file != '' ? eps_file.name : ''"
                                                        readonly
                                                        placeholder="Ningún archivo seleccionado"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="afp_pension_id" class="form-label">Fondo Pensiones*</label>
                                                <select v-model="social_security_data.afp_pension_id" name="afp_pension_id" class="form-control"  id="afp_pension_id">
                                                    <option value="" disabled selected hidden>Seleccionar AFP</option>
                                                    <option v-for="afp_type in afp_types" :value="afp_type.id">{{ afp_type.name }}</option>
                                                </select>
                                                <span v-if="errors_social_security && errors_social_security.afp_pension_id" class="error text-danger" for="afp_pension_id">{{ errors_social_security.afp_pension_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="image" class="form-label">Certificado fondo de pensiones</label>
                                                <input
                                                    ref="afpPensionFileInput"
                                                    type="file"
                                                    accept=".pdf"
                                                    class="form-control d-none"
                                                    @change="handleAfpPensionFile"
                                                >
                                                <!-- <span v-if="errors_bank_information && errors_bank_information.image" class="error text-danger" for="image">{{ errors_bank_information.image[0] }}</span> -->

                                                <div class="input-group">
                                                    <button type="button" class="btn btn-primary" @click="selectAfpPensionFile">
                                                        <font-awesome-icon :icon="['fas', 'upload']" />
                                                        Seleccionar
                                                    </button>
                                                    <input
                                                        @click="selectAfpPensionFile"
                                                        type="text"
                                                        class="form-control"
                                                        :value="afp_pension_file != '' ? afp_pension_file.name : ''"
                                                        readonly
                                                        placeholder="Ningún archivo seleccionado"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="afp_saving_id" class="form-label">Fondo Cesantías*</label>
                                                <select v-model="social_security_data.afp_saving_id" name="afp_saving_id" class="form-control"  id="afp_saving_id">
                                                    <option value="" disabled selected hidden>Seleccionar AFP</option>
                                                    <option v-for="afp_type in afp_types" :value="afp_type.id">{{ afp_type.name }}</option>
                                                </select>
                                                <span v-if="errors_social_security && errors_social_security.afp_saving_id" class="error text-danger" for="afp_saving_id">{{ errors_social_security.afp_saving_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="image" class="form-label">Certificado fondo de cesantías</label>
                                                <input
                                                    ref="afpSavingFileInput"
                                                    type="file"
                                                    accept=".pdf"
                                                    class="form-control d-none"
                                                    @change="handleAfpSavingFile"
                                                >
                                                <!-- <span v-if="errors_bank_information && errors_bank_information.image" class="error text-danger" for="image">{{ errors_bank_information.image[0] }}</span> -->

                                                <div class="input-group">
                                                    <button type="button" class="btn btn-primary" @click="selectAfpSavingFile">
                                                        <font-awesome-icon :icon="['fas', 'upload']" />
                                                        Seleccionar
                                                    </button>
                                                    <input
                                                        @click="selectAfpSavingFile"
                                                        type="text"
                                                        class="form-control"
                                                        :value="afp_saving_file != '' ? afp_saving_file.name : ''"
                                                        readonly
                                                        placeholder="Ningún archivo seleccionado"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="ccf_id" class="form-label">Caja de compensación familiar*</label>
                                                <select v-model="social_security_data.ccf_id" name="ccf_id" class="form-control"  id="ccf_id">
                                                    <option value="" disabled selected hidden>Seleccionar caja de compensación</option>
                                                    <option v-for="ccf_type in ccf_types" :value="ccf_type.id">{{ ccf_type.name }}</option>
                                                </select>
                                                <span v-if="errors_social_security && errors_social_security.ccf_id" class="error text-danger" for="ccf_id">{{ errors_social_security.ccf_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="arl_id" class="form-label">ARL*</label>
                                                <select v-model="social_security_data.arl_id" name="arl_id" class="form-control"  id="arl_id">
                                                    <option value="" disabled selected hidden>Seleccionar ARL</option>
                                                    <option v-for="arl_type in arl_types" :value="arl_type.id">{{ arl_type.name }}</option>
                                                </select>
                                                <span v-if="errors_social_security && errors_social_security.arl_id" class="error text-danger" for="arl_id">{{ errors_social_security.arl_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="observations_social_security" class="form-label">Observaciones</label>
                                                <textarea v-model="social_security_data.observations" name="observations_social_security" id="observations_social_security" type="text" class="form-control" placeholder="Ingrese sus observaciones" rows="4" cols="50"></textarea>
                                                <span v-if="errors_social_security && errors_social_security.observations" class="error text-danger" for="observations">{{ errors_social_security.observations[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex">
                                    <!-- Los campos marcados con * son obligatorios. -->
                                    <button type="submit" class="btn btn-primary">Actualizar</button>

                                    <button @click="resetSocialSecurity" type="button" class="btn btn-secondary mx-2">Cancelar</button>

                                    <!-- <span class="float-end text-muted" style="font-size: 0.95em;">Los campos marcados con * son obligatorios.</span> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div v-else class="empty-state mb-3">
                    <div class="empty-state__art" aria-hidden="true">
                        <svg width="140" height="100" viewBox="0 0 300 200" role="img">
                            <defs>
                            <linearGradient id="grad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#eef2ff"/>
                                <stop offset="100%" stop-color="#e0f2fe"/>
                            </linearGradient>
                            </defs>
                            <rect x="20" y="50" width="260" height="110" rx="10" fill="url(#grad)" />
                            <rect x="40" y="70" width="220" height="18" rx="4" fill="#cbd5e1"/>
                            <rect x="40" y="96" width="160" height="18" rx="4" fill="#e2e8f0"/>
                            <rect x="40" y="122" width="190" height="18" rx="4" fill="#e2e8f0"/>
                        </svg>
                    </div>
                    <h2 class="empty-state__title">No hay información de seguridad social disponible.</h2>
                    <p class="empty-state__desc">Puedes agregarla haciendo clic <strong @click="addSocialSecurityData" style="cursor: pointer;color: #127cb3;">aquí</strong>.</p>
                </div>
            </div>

            <div class="col-md-12 col-xl-6">
                <div v-if="bank_information_data">
                    <button @click="editBankInformation" type="button" class="mb-2 btn btn-mh-dark-blue mb-3"><i class="fa fa-edit"></i>  Editar</button>
                    <button @click="deleteBankAccount(bank_information_data.id)" type="button" class="mb-2 btn btn-danger mb-3 mx-2"><i class="fa fa-trash"></i>  Eliminar</button>
                </div>
                <div v-else>
                    <button @click="addBankInformation" type="button" class="mb-2 btn btn-mh-dark-blue mb-3"><i class="fa fa-plus"></i>  Agregar</button>
                </div>

                <div v-if="bank_information_data != null && add_bank_information_data === false && edit_bank_information_data === false && show_bank_information_data === false" class="card-hover-shadow card-border mb-3 card frame-information-card">
                    <div class="card-header">
                        Información Bancaria
                    </div>
                    <div class="card-body">
                        <div class="wrapper-social-bank">
                            <div class="data-pair">
                                <div class="box-label lb-44">
                                    <p class="">Banco:</p>
                                </div>
                                <div class="box-value vl-44">
                                    <p class="">{{ bank_information_data.bank.name }}</p>
                                </div>
                            </div>
                            <div class="data-pair">
                                <div class="box-label lb-45">
                                    <p class="">Número de cuenta:</p>
                                </div>
                                <div class="box-value vl-45">
                                    <p class="">{{ bank_information_data.bank_account }}</p>
                                </div>
                            </div>
                            <div class="data-pair full-width without-border">
                                <div class="box-label lb-46">
                                    <p class="">Observaciones:</p>
                                </div>
                                <div class="box-value vl-46">
                                    <p class="">{{ bank_information_data.observations }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="bank_information_data && bank_information_data.bank_certificate_url" class="card-footer">
                        <div class="buttons-container">
                            <button @click="downloadBankAccountCertificate(bank_information_data.id)" class="btn-icon btn btn-primary">
                                <font-awesome-icon :icon="['fas', 'download']" /> Certificado de cuenta bancaria
                            </button>
                        </div>
                        <!-- <div v-else class="text-muted">
                            <span style="font-style: italic;">No hay certificado de cuenta bancaria disponible.</span>
                        </div> -->
                    </div>
                </div>
                <div v-else-if="bank_information_data === null && add_bank_information_data === true && edit_bank_information_data === false && show_bank_information_data === false">
                    <div class="col-12">
                        <form @submit.prevent="storeBankInformation" enctype="multipart/form-data">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información Bancaria
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="bank_id" class="form-label">Banco*</label>
                                                <select v-model="bank_id" name="bank_id" class="form-control"  id="bank_id">
                                                    <option value="" disabled selected hidden>Seleccionar Banco</option>
                                                    <option v-for="bank_type in bank_types" :value="bank_type.id">{{ bank_type.name }}</option>
                                                </select>
                                                <span v-if="errors_bank_information && errors_bank_information.bank_id" class="error text-danger" for="bank_id">{{ errors_bank_information.bank_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="bank_account" class="form-label">Número de cuenta*</label>
                                                <input v-model="bank_account" name="bank_account" id="bank_account" type="text" class="form-control" placeholder="Ingrese número de cuenta">
                                                <span v-if="errors_bank_information && errors_bank_information.bank_account" class="error text-danger" for="bank_account">{{ errors_bank_information.bank_account[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="image" class="form-label">Certificado de cuenta</label>
                                                <input
                                                    ref="bankAccountFileInput"
                                                    type="file"
                                                    accept=".pdf"
                                                    class="form-control d-none"
                                                    @change="handleBankAccountFile"
                                                >
                                                <!-- <span v-if="errors_bank_information && errors_bank_information.image" class="error text-danger" for="image">{{ errors_bank_information.image[0] }}</span> -->

                                                <div class="input-group">
                                                    <button type="button" class="btn btn-primary" @click="selectBankAccountFile">
                                                        <font-awesome-icon :icon="['fas', 'upload']" />
                                                        Seleccionar
                                                    </button>
                                                    <input
                                                        @click="selectBankAccountFile"
                                                        type="text"
                                                        class="form-control"
                                                        :value="bank_account_file != '' ? bank_account_file.name : ''"
                                                        readonly
                                                        placeholder="Ningún archivo seleccionado"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="observations_bank_information" class="form-label">Observaciones</label>
                                                <textarea v-model="observations_bank_information" name="observations_bank_information" id="observations_bank_information" type="text" class="form-control" placeholder="Ingrese sus observaciones" rows="4" cols="50"></textarea>
                                                <span v-if="errors_bank_information && errors_bank_information.observations" class="error text-danger" for="observations">{{ errors_bank_information.observations[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex">
                                    <!-- Los campos marcados con * son obligatorios. -->
                                    <button type="submit" class="btn btn-primary">Guardar</button>

                                    <button @click="resetBankInformation" type="button" class="btn btn-secondary mx-2">Cancelar</button>

                                    <!-- <span class="float-end text-muted" style="font-size: 0.95em;">Los campos marcados con * son obligatorios.</span> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div v-else-if="bank_information_data != null && add_bank_information_data === false && edit_bank_information_data === true && show_bank_information_data === false">
                    <div class="col-12">
                        <form @submit.prevent="updateBankInformation" enctype="multipart/form-data">
                            <div class="card-hover-shadow card-border mb-3 card">
                                <div class="card-header">
                                    Información Bancaria
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="bank_id" class="form-label">Banco*</label>
                                                <select v-model="bank_information_data.bank_id" name="bank_id" class="form-control"  id="bank_id">
                                                    <option value="" disabled selected hidden>Seleccionar Banco</option>
                                                    <option v-for="bank_type in bank_types" :value="bank_type.id">{{ bank_type.name }}</option>
                                                </select>
                                                <span v-if="errors_bank_information && errors_bank_information.bank_id" class="error text-danger" for="bank_id">{{ errors_bank_information.bank_id[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="bank_account" class="form-label">Número de cuenta*</label>
                                                <input v-model="bank_information_data.bank_account" name="bank_account" id="bank_account" type="text" class="form-control" placeholder="Ingrese número de cuenta">
                                                <span v-if="errors_bank_information && errors_bank_information.bank_account" class="error text-danger" for="bank_account">{{ errors_bank_information.bank_account[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-6">
                                            <div class="position-relative mb-3">
                                                <label for="image" class="form-label">Certificado de cuenta</label>
                                                <input
                                                    ref="bankAccountFileInput"
                                                    type="file"
                                                    accept=".pdf"
                                                    class="form-control d-none"
                                                    @change="handleBankAccountFile"
                                                >
                                                <!-- <span v-if="errors_bank_information && errors_bank_information.image" class="error text-danger" for="image">{{ errors_bank_information.image[0] }}</span> -->

                                                <div class="input-group">
                                                    <button type="button" class="btn btn-primary" @click="selectBankAccountFile">
                                                        <font-awesome-icon :icon="['fas', 'upload']" />
                                                        Seleccionar
                                                    </button>
                                                    <input
                                                        @click="selectBankAccountFile"
                                                        type="text"
                                                        class="form-control"
                                                        :value="bank_account_file != '' ? bank_account_file.name : ''"
                                                        readonly
                                                        placeholder="Ningún archivo seleccionado"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="position-relative mb-3">
                                                <label for="observations_bank_information" class="form-label">Observaciones</label>
                                                <textarea v-model="bank_information_data.observations" name="observations_bank_information" id="observations_bank_information" type="text" class="form-control" placeholder="Ingrese sus observaciones" rows="4" cols="50"></textarea>
                                                <span v-if="errors_bank_information && errors_bank_information.observations" class="error text-danger" for="observations">{{ errors_bank_information.observations[0] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex">
                                    <!-- Los campos marcados con * son obligatorios. -->
                                    <button type="submit" class="btn btn-primary">Actualizar</button>

                                    <button @click="resetBankInformation" type="button" class="btn btn-secondary mx-2">Cancelar</button>

                                    <!-- <span class="float-end text-muted" style="font-size: 0.95em;">Los campos marcados con * son obligatorios.</span> -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div v-else-if="bank_information_data === null && add_bank_information_data === false && edit_bank_information_data === false && show_bank_information_data === false" class="empty-state mb-3">
                    <div class="empty-state__art" aria-hidden="true">
                        <svg width="140" height="100" viewBox="0 0 300 200" role="img">
                            <defs>
                            <linearGradient id="grad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#eef2ff"/>
                                <stop offset="100%" stop-color="#e0f2fe"/>
                            </linearGradient>
                            </defs>
                            <rect x="20" y="50" width="260" height="110" rx="10" fill="url(#grad)" />
                            <rect x="40" y="70" width="220" height="18" rx="4" fill="#cbd5e1"/>
                            <rect x="40" y="96" width="160" height="18" rx="4" fill="#e2e8f0"/>
                            <rect x="40" y="122" width="190" height="18" rx="4" fill="#e2e8f0"/>
                        </svg>
                    </div>
                    <h2 class="empty-state__title">No hay información bancaria disponible.</h2>
                    <p class="empty-state__desc">Puedes agregarla haciendo clic <strong @click="addBankInformation" style="cursor: pointer;color: #127cb3;">aquí</strong>.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'CollaboratorSocialSecurity',
    props: {
        collaborator: {
            default: null,
        },
    },
    data() {
        return {
            is_loading: false,
            social_security_data: null,
            bank_information_data: null,

            eps_types: [],
            arl_types: [],
            afp_types: [],
            ccf_types: [],

            bank_types: [],

            eps_id: '',
            arl_id: '',
            afp_pension_id: '',
            afp_saving_id: '',
            ccf_id: '',
            observations_social_security: '',

            bank_id: '',
            bank_account: '',
            observations_bank_information: '',

            add_social_security_data: false,
            edit_social_security_data: false,
            show_social_security_data: false,

            add_bank_information_data: false,
            edit_bank_information_data: false,
            show_bank_information_data: false,

            eps_file: '',
            eps_file_name: '',

            afp_pension_file: '',
            afp_pension_file_name: '',

            afp_saving_file: '',
            afp_saving_file_name: '',

            bank_account_file: '',
            bank_account_file_name: '',

            message: '',

            errors_social_security: null,
            errors_bank_information: null,
        };
    },
    mounted() {
        this.getSocialSecurityInformation();
        this.getBankAccountInformation();
        this.getSocialSecurityByCollaborator();
        this.getBankAccountByCollaborator();
    },
    methods: {
        getMessage(msg) {
            if(msg != '' && msg != null) {
                this.message = msg
            }

            setTimeout(() => {
                this.message = ''
            }, 3000)
        },
        selectEpsFile() {
            this.$refs.epsFileInput.click();
        },
        handleEpsFile(e) {
            this.eps_file = e.target.files[0];
            this.eps_file_name = this.eps_file ? this.eps_file.name : '';
        },
        selectAfpPensionFile() {
            this.$refs.afpPensionFileInput.click();
        },
        handleAfpPensionFile(e) {
            this.afp_pension_file = e.target.files[0];
            this.afp_pension_file_name = this.afp_pension_file ? this.afp_pension_file.name : '';
        },
        selectAfpSavingFile() {
            this.$refs.afpSavingFileInput.click();
        },
        handleAfpSavingFile(e) {
            this.afp_saving_file = e.target.files[0];
            this.afp_saving_file_name = this.afp_saving_file ? this.afp_saving_file.name : '';
        },
        selectBankAccountFile() {
            this.$refs.bankAccountFileInput.click();
        },
        handleBankAccountFile(e) {
            this.bank_account_file = e.target.files[0];
            this.bank_account_file_name = this.bank_account_file ? this.bank_account_file.name : '';
        },
        getSocialSecurityInformation() {
            axios.get(`/social-security-information`)
            .then(response => {
                this.eps_types = response.data.eps_types;
                this.arl_types = response.data.arl_types;
                this.afp_types = response.data.afp_types;
                this.ccf_types = response.data.ccf_types;
            })
            .catch(e => {
                //
            })
        },
        getBankAccountInformation() {
            axios.get(`/bank-account-information`)
            .then(response => {
                this.bank_types = response.data.bank_types;
            })
            .catch(e => {
                //
            })
        },
        getSocialSecurityByCollaborator() {
            axios.get(`/social-security-information/${this.collaborator.id}`)
            .then(response => {
                this.social_security_data = response.data.social_security;
            })
            .catch(e => {
                //
            })
        },
        getBankAccountByCollaborator() {
            axios.get(`/bank-account-information/${this.collaborator.id}`)
                .then(response => {
                    this.bank_information_data = response.data.bank_account;
                })
                .catch(e => {
                    // Manejo de errores
                })
        },
        addSocialSecurityData(){
            if (this.social_security_data === null && this.add_social_security_data === true && this.edit_social_security_data === false && this.show_social_security_data === false) {
                this.resetSocialSecurity()
            } else {
                this.social_security_data = null
                this.add_social_security_data = true
                this.edit_social_security_data = false
                this.show_social_security_data = false
            }
        },
        addBankInformation(){
            if (this.bank_information_data === null && this.add_bank_information_data === true && this.edit_bank_information_data === false && this.show_bank_information_data === false) {
                this.resetBankInformation()
            } else {
                this.bank_information_data = null
                this.add_bank_information_data = true
                this.edit_bank_information_data = false
                this.show_bank_information_data = false
            }
        },
        editSocialSecurityData(){
            if (this.social_security_data != null && this.add_social_security_data === false && this.edit_social_security_data === true && this.show_social_security_data === false) {
                this.resetSocialSecurity()
            } else {
                this.add_social_security_data = false
                this.edit_social_security_data = true
                this.show_social_security_data = false
            }
        },
        editBankInformation(){
            if (this.bank_information_data != null && this.add_bank_information_data === false && this.edit_bank_information_data === true && this.show_bank_information_data === false) {
                this.resetBankInformation()
            } else {
                this.add_bank_information_data = false
                this.edit_bank_information_data = true
                this.show_bank_information_data = false
            }
        },
        downloadEpsCertificate(eps_id) {
            axios.get(`/download-eps-certificate/${eps_id}`)
            .then(response => {
                window.open(response.data.certificate_download_url, '_blank');
            })
            .catch(e => {
                // console.error('Error:', e);
            })
        },
        downloadAfpPensionCertificate(afp_pension_id) {
            axios.get(`/download-afp-pension-certificate/${afp_pension_id}`)
            .then(response => {
                window.open(response.data.certificate_download_url, '_blank');
            })
            .catch(e => {
                // console.error('Error:', e);
            })
        },
        downloadAfpSavingCertificate(afp_saving_id) {
            axios.get(`/download-afp-saving-certificate/${afp_saving_id}`)
            .then(response => {
                window.open(response.data.certificate_download_url, '_blank');
            })
            .catch(e => {
                // console.error('Error:', e);
            })
        },
        downloadBankAccountCertificate(bank_account_id) {
            axios.get(`/download-bank-account-certificate/${bank_account_id}`)
            .then(response => {
                window.open(response.data.certificate_download_url, '_blank');
            })
            .catch(e => {
                // console.error('Error:', e);
            })
        },
        storeSocialSecurityInformation() {
            this.is_loading = true;
            this.errors_social_security = null;

            let fd = new FormData()

            fd.append('collaborator_id', this.collaborator.id)
            fd.append('eps_id', this.eps_id)
            fd.append('eps_file', this.eps_file)
            fd.append('afp_pension_id', this.afp_pension_id)
            fd.append('afp_pension_file', this.afp_pension_file)
            fd.append('afp_saving_id', this.afp_saving_id)
            fd.append('afp_saving_file', this.afp_saving_file)
            fd.append('ccf_id', this.ccf_id)
            fd.append('arl_id', this.arl_id)
            fd.append('observations', this.observations_social_security)

            axios.post(`/social-security-information`, fd).then(
                (res) => {
                    this.getSocialSecurityByCollaborator();
                    this.getMessage(res.data.message);
                    this.resetSocialSecurity();
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors_social_security = error.response.data.errors
                    }
                }).finally(() => {
                    this.is_loading = false;
                })
        },
        storeBankInformation() {
            this.is_loading = true; // ACTIVAR
            this.errors_bank_information = null;

            let fd = new FormData()
            fd.append('collaborator_id', this.collaborator.id)
            fd.append('bank_id', this.bank_id)
            fd.append('bank_account', this.bank_account)
            fd.append('bank_account_file', this.bank_account_file)
            fd.append('observations', this.observations_bank_information)

            axios.post(`/bank-account-information`, fd).then(
                (res) => {
                    this.getBankAccountByCollaborator();
                    this.getMessage(res.data.message);
                    this.resetBankInformation();
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors_bank_information = error.response.data.errors
                    }
                }).finally(() => {
                    this.is_loading = false; // DESACTIVAR
                })
        },
        updateSocialSecurityInformation() {
            this.is_loading = true;
            this.errors_social_security = null;

            let fd = new FormData()

            fd.append('collaborator_id', this.collaborator.id)
            fd.append('eps_id', this.social_security_data.eps_id)
            fd.append('eps_file', this.eps_file)
            fd.append('afp_pension_id', this.social_security_data.afp_pension_id)
            fd.append('afp_pension_file', this.afp_pension_file)
            fd.append('afp_saving_id', this.social_security_data.afp_saving_id)
            fd.append('afp_saving_file', this.afp_saving_file)
            fd.append('ccf_id', this.social_security_data.ccf_id)
            fd.append('arl_id', this.social_security_data.arl_id)
            fd.append('observations', this.social_security_data.observations)
            fd.append('_method', 'PUT')

            axios.post(`/social-security-information/${this.social_security_data.id}`, fd).then(
                (response) => {
                    this.getSocialSecurityByCollaborator();
                    this.getMessage(response.data.message)
                    this.resetSocialSecurity();
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors_social_security = error.response.data.errors
                    }
                }).finally(() => {
                    this.is_loading = false;
                })
        },
        updateBankInformation(){
            this.is_loading = true; // ACTIVAR
            this.errors_bank_information = null;

            let fd = new FormData()
            fd.append('collaborator_id', this.collaborator.id)
            fd.append('bank_id', this.bank_information_data.bank_id)
            fd.append('bank_account', this.bank_information_data.bank_account)
            fd.append('bank_account_file', this.bank_account_file)
            fd.append('observations', this.bank_information_data.observations)
            fd.append('_method', 'PUT')

            axios.post(`/bank-account-information/${this.bank_information_data.id}`, fd).then(
                (response) => {
                    this.getBankAccountByCollaborator()
                    this.getMessage(response.data.message)
                    this.resetBankInformation();
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors_bank_information = error.response.data.errors
                    }
                }).finally(() => {
                    this.is_loading = false; // DESACTIVAR
                })
        },
        deleteSocialSecurity(id){
            this.is_loading = true;

            axios.delete(`/social-security-information/${id}`).then(
                (res) => {
                    this.getSocialSecurityByCollaborator();
                    this.getMessage(res.data.message);
                    this.resetSocialSecurity();
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors_social_security = error.response.data.errors
                    }
                }).finally(() => {
                    this.is_loading = false;
                })
        },
        deleteBankAccount(id){
            this.is_loading = true; // ACTIVAR

            axios.delete(`/bank-account-information/${id}`).then(
                (res) => {
                    this.getBankAccountByCollaborator();
                    this.getMessage(res.data.message);
                    this.resetBankInformation();
                }).catch(
                (error) => {
                    if(error && error.response && error.response.data && error.response.data.errors) {
                        this.errors_bank_information = error.response.data.errors
                    }
                }).finally(() => {
                    this.is_loading = false; // DESACTIVAR
                })
        },
        resetSocialSecurity(){
            this.getSocialSecurityByCollaborator();
            this.add_social_security_data = false
            this.edit_social_security_data = false
            this.show_social_security_data = false
            this.errors_social_security = null
        },
        resetBankInformation(){
            this.getBankAccountByCollaborator();
            this.add_bank_information_data = false
            this.edit_bank_information_data = false
            this.show_bank_information_data = false
            this.errors_bank_information = null
        },
    },
};
</script>

<style scoped>
/* .loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.85);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 1050;
    border-radius: 12px;
} */

.loading-overlay {
    position: fixed; /* Cambiado de absolute a fixed */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.85);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 9999; /* Asegura que esté por encima de todo el sitio web */
    /* border-radius: 12px; <- Elimina esto para que no se vean bordes redondeados en pantalla completa */
}

.loading-text {
    font-weight: 500;
    color: #333;
}

.buttons-container {
    display: flex;
    gap: 10px;
    /* justify-content: space-between; */
}

@media (max-width: 576px) {
    .buttons-container {
        flex-direction: column;
    }

    .buttons-container button {
        width: 100%;
    }
}

.empty-state {
    border: 1px dashed #e5e7eb;
    border-radius: 12px;
    padding: 28px;
    text-align: center;
    background: #ffffff;
}

.empty-state__art { margin-bottom: 14px; }

.empty-state__title {
    font-size: 1.15rem;
    margin: 8px 0 4px;
    color: #0f172a;
}

.empty-state__desc {
    color: #475569;
    margin-bottom: 14px;
}

.empty-state__actions .btn {
    min-width: 160px;
}

.without-border {
    border-bottom: none;
}
</style>
