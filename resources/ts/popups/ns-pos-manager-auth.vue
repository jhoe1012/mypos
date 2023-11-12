<template>
    <div class="shadow-lg flex flex-col ns-box w-95vw h-50vh md:w-3/5-screen md:h-1/2-screen lg:w-2/5-screen">
        <div class="p-2 border-b ns-box-header items-center flex justify-between">
            <h3 class="font-medium text-semibold">{{ __('Manager Authorization') }}</h3>
            <div>
                <ns-close-button @click="closePopup()"></ns-close-button>
            </div>
        </div>
        <div class="p-2 flex-auto border-b ns-box-body overflow-y-auto" @keyup.enter="login()">
            <ns-field :field="field" v-for="(field, index) of fields" :key="index"></ns-field>
        </div>
        <div class="p-2 flex justify-end ns-box-footer">
            <ns-button @click="login()" type="info">{{ __('Authenticate') }}</ns-button>
        </div>
    </div>
</template>
<script>
import FormValidation from '@/libraries/form-validation';
export default {
    name: 'ns-pos-manager-auth',
    mounted() {
        nsHttpClient.get('/api/nexopos/v4/fields/ns.login')
            .subscribe(fields => {
                this.fields = this.validation.createFields(fields);
                this.xsrfToken = nsHttpClient.response.config.headers['X-XSRF-TOKEN'];
            }, (error) => {

            });

        this.popupCloser();
    },
    data() {
        return {
            fields: [],
            validation: new FormValidation,
            xsrfToken: null,
            isSubmitting: false,
            result: []
        }
    },
    methods: {
        __,
        popupCloser,
        popupResolver,

        closePopup() {
            this.popupResolver(false);
        },

        async login() {
            const isValid = this.validation.validateFields(this.fields);

            if (!isValid) {
                return nsSnackBar.error(__('Unable to proceed the form is not valid.')).subscribe();
            }

            this.validation.disableFields(this.fields);
            this.isSubmitting = true;

            try {
                const response =  await new Promise((resolve, reject) => {
                    nsHttpClient.post('/api/nexopos/v4/manager_auth/sign-in', this.validation.getValue(this.fields), {
                        headers: {
                            'X-XSRF-TOKEN': this.xsrfToken
                        }
                    }).subscribe({
                        next: (result) => {
                            resolve( result )

                        },
                        error: (error) => {
                            this.isSubmitting = false;
                            this.validation.enableFields(this.fields);

                            if (error.data) {
                                this.validation.triggerFieldsErrors(this.fields, error.data);
                            }

                            nsSnackBar.error(error.message).subscribe();
                        }
                    })
                });
             this.popupResolver( response );

            } catch (exception) {
                // we shouldn't catch any exception here.
            }
        }

    }
}
</script>