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
                property: 'productName',
                dataIndex: 'productName',
                label: this.$t('as-disposition-control.general.columnProductID'),
                allowResize: true,
                primary: true
            }
            ,{
                property: 'productNumber',
                dataIndex: 'productNumber',
                label: this.$t('as-disposition-control.general.columnProductNumber'),
                allowResize: true
            }
            ,{
                property: 'stock',
                dataIndex: 'stock',
                label: this.$t('as-disposition-control.general.columnStock'),
                allowResize: true
            }
            ,{
                property: 'outgoing',
                dataIndex: 'outgoing',
                label: this.$t('as-disposition-control.general.columnOutgoing'),
                allowResize: true
            }
            ,{
                property: 'stockAvailable',
                dataIndex: 'stockAvailable',
                label: this.$t('as-disposition-control.general.columnStockAvailable'),
                allowResize: true
            }
            ,{
                property: 'incoming',
                dataIndex: 'incoming',
                label: this.$t('as-disposition-control.general.columnIncoming'),
                allowResize: true,
                inlineEdit: 'number'
            }
            ,{
                property: 'notificationThreshold',
                dataIndex: 'notificationThreshold',
                label: this.$t('as-disposition-control.general.columnNotificationThreshold'),
                allowResize: true,
                inlineEdit: 'number'
            }
            ,{
                property: 'minimumThreshold',
                dataIndex: 'minimumThreshold',
                label: this.$t('as-disposition-control.general.columnMinimumThreshold'),
                allowResize: true,
                inlineEdit: 'number'
            }
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