<template>
    
</template>
<script>
import { nsHttpClient, nsSnackBar } from '@/bootstrap';
import { default as nsDateTimePicker } from '@/components/ns-date-time-picker';
import nsDatepicker from "@/components/ns-datepicker";
import { __ } from '@/libraries/lang';
import moment from "moment";

export default {
    name: 'ns-inventory-report',
    data() {
        return {
            startDate: moment(),
            endDate: moment(),
            results: [],
            // users: [],
            summary: [],
            
            field: {
                type: 'datetimepicker',
                value: '2021-02-07',
                name: 'date'
            }
        }
    },
    components: {
        nsDatepicker,
        nsDateTimePicker,
    },
    computed: {
        // ..
    },
    methods: {
        // printSaleReport() {
        //     this.$htmlToPaper( 'sale-report' );
        // },
        setStartDate( moment ) {
            this.startDate  =   moment.format();
        },

        setEndDate( moment ) {
            this.endDate    =   moment.format();
        },
        
        loadReport() {
            if ( this.startDate === null || this.endDate ===null ) {
                return nsSnackBar.error( __( 'Unable to proceed. Select a correct time range.' ) ).subscribe();
            }

            const startMoment   =   moment( this.startDate );
            const endMoment     =   moment( this.endDate );

            if ( endMoment.isBefore( startMoment ) ) {
                return nsSnackBar.error( __( 'Unable to proceed. The current time range is not valid.' ) ).subscribe();
            }

            nsHttpClient.post( '/api/nexopos/v4/reports/inventory-report', { 
                startDate: this.startDate,
                endDate: this.endDate,
                // type: this.reportType.value,
                // user_id: this.filterUser.value
            }).subscribe({
                next: response => {
                    this.results     =   response.results;
                    this.summary    =   response.summary;
                }, 
                error : ( error ) => {
                    nsSnackBar.error( error.message ).subscribe();
                }
            });
        },

        computeTotal( collection, attribute ) {
            if ( collection.length > 0 ) {
                return collection.map( entry => parseFloat( entry[ attribute ] ) )
                    .reduce( ( b, a ) => b + a );
            }

            return 0;
        },

        
    }
}
</script>