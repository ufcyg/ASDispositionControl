import './page/as-disposition-control-overview';

import deDE from './snippet/de-DE.json';
import enGB from './snippet/en-GB.json';

Shopware.Module.register('as-disposition-control', {
    type: 'plugin',
    name: 'dispositionControl',
    title: 'as-disposition-control.general.mainMenuItemGeneral',
    description: 'as-disposition-control.general.descriptionTextModule',
    color: '#ad00ad',
    icon: 'default-communication-envelope',

    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },

    routes: {
        overview: {
            component: 'as-disposition-control-overview',
            path: 'overview'
        },
    },

    navigation: [{
        label: 'as-disposition-control.general.mainMenuItemGeneral',
        color: '#62ff80',
        path: 'as.disposition.control.overview',
        icon: 'default-communication-envelope',
        position: 11
    }],
});