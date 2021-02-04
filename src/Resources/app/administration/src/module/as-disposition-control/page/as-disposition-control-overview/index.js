import template from './as-disposition-control-overview.html.twig';

const { Criteria } = Shopware.Data;

Shopware.Component.register('as-disposition-control-overview', {
    template,
    inject: [
        'repositoryFactory'
    ],
    data() {
        return {
            repository: null,
            entries: null
        };
    },
    metaInfo() {
        return {
            title: this.$createTitle()
        };
    },
    computed: {
        columns() {
            return [{
                property: 'targetMail',
                dataIndex: 'targetMail',
                label: this.$t('as-disposition-control.general.columnTargetMail'),
                allowResize: true,
                primary: true
            }
            // ,{
            //     property: 'token',
            //     dataIndex: 'token',
            //     label: this.$t('as-steered-customer-registration.general.token'),
            //     allowResize: true
            // }
            ];
        }
    },
    created() {
        this.repository = this.repositoryFactory.create('as_dispo_control_data')
    
        this.repository
            .search(new Criteria(), Shopware.Context.api)
            .then((result) => {
                this.entries = result;
            });
    },
    methods: {
        async onUploadsAdded() {
            await this.mediaService.runUploads(this.uploadTag);
            this.reloadList();
        },

        onUploadFinished({ targetId }) {
            this.uploads = this.uploads.filter((upload) => {
                return upload.id !== targetId;
            });
        },

        onUploadFailed({ targetId }) {
            this.uploads = this.uploads.filter((upload) => {
                return targetId !== upload.id;
            });
        }
    }
});