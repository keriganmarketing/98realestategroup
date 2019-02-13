<template>
    <div class="feat-prop-container">
        <div class="embed-responsive embed-responsive-16by9">
            <div class="feat-prop-photo">
                <span v-if="listingData.status == 'Sold/Closed'" class="status-flag sold">
                    Sold on {{ formatDate(listingData.sold_on,'MM/DD/YYYY') }}<br>
                    for ${{ listingData.sold_for.toLocaleString() }}</span>
                <span v-if="listingData.status == 'Pending'" class="status-flag under-contract">SALE PENDING</span>
                <span v-if="listingData.status == 'Contingent'" class="status-flag contingent">SALE CONTINGENT</span>
                <img :src="listingData.media_objects.data[0].url" class="img-responsive"
                        :alt="'MLS Property ' + listingData.mls_account + ' for sale in ' + listingData.city"/>
            </div>
        </div>
        <div class="feat-prop-info">

            <div class="feat-prop-section">
                <span class="addr1">{{ listingData.street_num + ' ' + listingData.street_name }}</span>
                <span v-if="listingData.unit_num != ''" class="unit">{{ listingData.unit_num }}</span>
                <br><span class="city">{{ listingData.city }}</span>, <span
                    class="state">{{ listingData.state }}</span><br>
                    <span style="font-size:12px;">{{ listingData.prop_type }}</span>
            </div>

            <div class="feat-prop-section price">
                <p><span class="price">${{ listingData.price.toLocaleString() }}</span></p>
            </div>

            <div class="feat-prop-section" style="padding-bottom:1rem;">
                <div class="row justify-content-center" style="display:flex; justify-content:center; flex-wrap:wrap;" >
                    <div class="col-xs-4" v-if="listingData.bedrooms != null" >
                        <span class="icon"><img src="/wp-content/themes/98/img/rooms.svg" alt="rooms"
                                                class="img-responsive lazy"></span>
                        <span class="beds-num icon-data">{{ listingData.bedrooms.toLocaleString() }}</span>
                        <span class="icon-label">ROOMS</span>
                    </div>
                    <div class="col-xs-4 text-xs-center" v-if="listingData.total_bathrooms != null">
                        <span class="icon"><img src="/wp-content/themes/98/img/baths.svg" alt="bathrooms"
                                                class="img-responsive lazy"></span>
                        <span class="baths-num icon-data">{{ listingData.total_bathrooms.toLocaleString() }}</span>
                        <span class="icon-label">BATHS</span>
                    </div>
                    <div class="col-xs-4 text-xs-center" v-if="listingData.total_hc_sqft != null">
                        <span class="icon"><img src="/wp-content/themes/98/img/sqft.svg" alt="sqft"
                                                class="img-responsive lazy"></span>
                        <span class="sqft-num icon-data">{{ listingData.total_hc_sqft.toLocaleString() }}</span>
                        <span class="icon-label">H/C SQFT</span>
                    </div>
                    <div class="col-xs-4 text-xs-center" v-if="listingData.lot_dimensions != null">
                        <span class="icon"><img src="/wp-content/themes/98/img/lotsize.svg" alt="lot size"
                                                class="img-responsive lazy"></span>
                        <span
                            class="lot-dim-num icon-data">{{ listingData.lot_dimensions }}</span>
                        <span class="icon-label">LOT SIZE</span>
                    </div>
                    <div class="col-xs-4 text-xs-center" v-if="listingData.acreage.toLocaleString() != null">
                        <span class="icon"><img src="/wp-content/themes/98/img/acres.svg" alt="acres"
                                                class="img-responsive lazy"></span>
                        <span class="acres-num icon-data">&nbsp;{{ listingData.acreage }}&nbsp;</span>
                        <span class="icon-label">ACRES</span>
                    </div>
                </div>

            </div>
            <p class="text-xs-center"><a class="btn btn-danger" :href="'/listing/' + listingData.mls_account">View Property</a></p>
            <div class="feat-prop-section text-xs-center">
                <span class="mlsnum">MLS# {{ listingData.mls_account }}</span>
            </div>

        </div>
    </div>
</template>

<script>
import moment from 'moment'
export default {
    props: ['listingData'],
    methods: {
        formatDate(string, format){
            return moment(String(string)).format(format);
        }
    }
}
</script>
