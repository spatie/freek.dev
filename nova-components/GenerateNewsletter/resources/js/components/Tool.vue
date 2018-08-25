<template>
    <div>
        <heading class="mb-6">Generate Newsletter</heading>

        <card class="py-3 px-6">
            <div class="flex border-b border-40">
                <div class="w-1/4 py-4">
                    <slot>
                        <h4 class="font-normal text-80">
                            Edition number
                        </h4>
                    </slot>
                </div>
                <div class="w-3/4 py-4">
                    <slot name="value">
                        <input
                          v-model="form.editionNumber"
                          type="text"
                          class="w-full form-control form-input form-input-bordered flatpickr-input active"
                        />

                    </slot>
                </div>
            </div>

            <div class="flex border-b border-40">
                <div class="w-1/4 py-4">
                    <slot>
                        <h4 class="font-normal text-80">
                            Start date
                        </h4>
                    </slot>
                </div>
                <div class="w-3/4 py-4">
                    <slot name="value">
                        <input
                          v-model="form.startDate"
                          type="text"
                          placeholder="2018-01-01"
                          class="w-full form-control form-input form-input-bordered flatpickr-input active"
                        />

                    </slot>
                </div>
            </div>

            <div class="flex border-b border-40">
                <div class="w-1/4 py-4">
                    <slot>
                        <h4 class="font-normal text-80">
                            End date
                        </h4>
                    </slot>
                </div>
                <div class="w-3/4 py-4">
                    <slot name="value">
                        <input
                          v-model="form.endDate"
                          type="text"
                          placeholder="2018-01-01"
                          class="w-full form-control form-input form-input-bordered flatpickr-input active"
                        />
                    </slot>
                </div>
            </div>

            <div class="flex border-b border-40" v-if="newsletterHtml !== ''">
                <div class="w-1/4 py-4">
                    <slot>
                        <h4 class="font-normal text-80">
                            Newsletter html
                        </h4>
                    </slot>
                </div>
                <div class="w-3/4 py-4">
                    <slot name="value">
                        <textarea
                          style="height: 270px"
                          v-model="newsletterHtml"
                          type="text"
                          class="w-full form-control form-input form-input-bordered flatpickr-input active"
                        ></textarea>
                    </slot>
                </div>
            </div>

        </card>
        <div class="bg-30 flex px-8 py-4">
            <button
              @click="generateNewsletter"
              type="button"
              class="ml-auto btn btn-default btn-primary mr-3">
            Generate newsletter
        </button></div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                editionNumber: null,
                startDate: null,
                endDate: null,
            },

            newsletterHtml: '',
        };
    },

    methods: {
        async generateNewsletter() {
            let response = await window.axios.post(
                '/nova-vendor/freekmurze/generate-newsletter',
                this.form
            );

            this.newsletterHtml = response.data;
        },
    },
};
</script>
