(this.webpackJsonp=this.webpackJsonp||[]).push([["a-s-disposition-control"],{b0Tg:function(o,e,t){"use strict";t.r(e);var n=t("uC6+"),i=t.n(n);const{Criteria:s}=Shopware.Data;Shopware.Component.register("as-disposition-control-overview",{template:i.a,inject:["repositoryFactory"],data:()=>({repository:null,entries:null}),metaInfo(){return{title:this.$createTitle()}},computed:{columns(){return[{property:"productName",dataIndex:"productName",label:this.$t("as-disposition-control.general.columnProductID"),allowResize:!0,primary:!0},{property:"productNumber",dataIndex:"productNumber",label:this.$t("as-disposition-control.general.columnProductNumber"),allowResize:!0},{property:"stock",dataIndex:"stock",label:this.$t("as-disposition-control.general.columnStock"),allowResize:!0},{property:"commissioned",dataIndex:"commissioned",label:this.$t("as-disposition-control.general.columnCommissioned"),allowResize:!0},{property:"stockAvailable",dataIndex:"stockAvailable",label:this.$t("as-disposition-control.general.columnStockAvailable"),allowResize:!0},{property:"incoming",dataIndex:"incoming",label:this.$t("as-disposition-control.general.columnIncoming"),allowResize:!0,inlineEdit:"number"},{property:"notificationThreshold",dataIndex:"notificationThreshold",label:this.$t("as-disposition-control.general.columnNotificationThreshold"),allowResize:!0,inlineEdit:"number"},{property:"minimumThreshold",dataIndex:"minimumThreshold",label:this.$t("as-disposition-control.general.columnMinimumThreshold"),allowResize:!0,inlineEdit:"number"}]}},created(){this.repository=this.repositoryFactory.create("as_dispo_control_data"),this.repository.search(new s,Shopware.Context.api).then(o=>{this.entries=o})},methods:{async onUploadsAdded(){await this.mediaService.runUploads(this.uploadTag),this.reloadList()},onUploadFinished({targetId:o}){this.uploads=this.uploads.filter(e=>e.id!==o)},onUploadFailed({targetId:o}){this.uploads=this.uploads.filter(e=>o!==e.id)}}});var l=t("pazC"),r=t("uHIU");Shopware.Module.register("as-disposition-control",{type:"plugin",name:"dispositionControl",title:"as-disposition-control.general.mainMenuItemGeneral",description:"as-disposition-control.general.descriptionTextModule",color:"#ad00ad",icon:"default-communication-envelope",snippets:{"de-DE":l,"en-GB":r},routes:{overview:{component:"as-disposition-control-overview",path:"overview"}},navigation:[{label:"as-disposition-control.general.mainMenuItemGeneral",color:"#0400ff",path:"as.disposition.control.overview",icon:"default-arrow-switch",position:11}]})},pazC:function(o){o.exports=JSON.parse('{"as-disposition-control":{"general":{"mainMenuItemGeneral":"Dispositions Kontrolle","descriptionTextModule":"Verwalten von Bestand und Bestellungen","columnProductID":"Produkt Name","columnProductNumber":"Produkt Nummer","columnStock":"Bestand","columnCommissioned":"In Kommissionierung","columnStockAvailable":"Verfügbarer Bestand","columnIncoming":"Offene Bestellungen","columnMinimumThreshold":"Sicherheitsbestand","columnNotificationThreshold":"Meldebestand","uploadWhitelist":"uploadButton"},"errors":{"creation":"Creation Error (deu)"},"detail":{"saveButtonText":"SpeichernButton","cancelButtonText":"AbbrechenButton"}}}')},"uC6+":function(o,e){o.exports='{% block disposition_control_overview %}\n    <sw-page class="disposition-control-list">\n        {% block swag_bundle_list_smart_bar_actions %}\n            <template slot="smart-bar-actions">\n                <sw-button variant="submit" >\n                    {{ $t(\'as-disposition-control.general.uploadWhitelist\') }}\n                </sw-button>\n            </template>\n        {% endblock %}\n\n        <template slot="content">\n            {% block disposition_control_list_content %}\n                <sw-entity-listing\n                    v-if="entries"\n                    :items="entries"\n                    :repository="repository"\n                    :showSelection="false"\n                    :columns="columns">\n                </sw-entity-listing>\n            {% endblock %}\n        </template>\n    </sw-page>\n{% endblock %}'},uHIU:function(o){o.exports=JSON.parse('{"as-steered-customer-registration":{"general":{"mainMenuItemGeneral":"Disposition Control","descriptionTextModule":"Monitoring Stock and Supply","columnProductID":"Productname","columnProductNumber":"Productnumber","columnStock":"Stock","columnCommissioned":"Commissioned","columnStockAvailable":"Available Stock","columnIncoming":"Open order volume","columnMinimumThreshold":"Minimum Stock","columnNotificationThreshold":"Reorder point","uploadWhitelist":"uploadButton"},"errors":{"creation":"Creation Error (eng)"},"detail":{"saveButtonText":"SaveButton","cancelButtonText":"CancelButton"}}}')}},[["b0Tg","runtime"]]]);