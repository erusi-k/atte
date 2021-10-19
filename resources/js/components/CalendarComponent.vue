<template>
    <div>
        <p @click="getData()">非同期テスト</p>
        <p @click="subtractMonth">前の月</p>
        <p>{{month.format('YYYY年MM月')}}</p>
        <p @click="addMonth">次の月</p>
        <div>
            <p v-if="message">実績がありません。</p>
            <table v-else >
                    <tr>
                        <th></th>
                        <th>出勤時間</th>
                        <th>退勤時間</th>
                        <th>休憩時間</th>
                        <th>合計時間</th>
                    </tr>
                    <!-- <div v-for="item in data" :key="item.id"> -->
                    <tr v-for="n in test" :key="n">
                        <td>{{n}}</td>
                        <div v-for="item in data" :key="item.id">
                            <div v-if="item.day == n">
                                <td>{{item.punchIn}}</td>
                                <td>{{item.punchOut}}</td>
                                <td>{{item.break}}</td>
                                <td>{{item.total}}</td>
                            </div>
                        </div>
                        </tr>
                    <!-- </div> -->
            </table>
        </div>
    </div>
</template>

<script>
import moment from "moment";
moment.locale('ja');
export default {
    props:['user_id'],
    data(){
        return{
            month:moment(),
            // last_day:moment().endOf('month').format('YYYY年MM月DD日'),
            last_day:moment(this.month).endOf('month'),
            first_day:moment(this.month).startOf('month').format('YYYY年MM月DD日'),
            day:moment(this.month).startOf('month'),
            data:'',
            message:false,
        }
    },
    methods:{
        
        addMonth(){
            this.month = moment(this.month).add(1,'month');
            this.getData();
        },

        subtractMonth(){
            this.month = moment(this.month).subtract(1,'month');
            this.getData();
        },

        async getData(){
            const response= await axios
                .get("http://localhost:8000/api/individual",{params:{user_id:this.user_id,day:this.month.format('YYYY-MM')}});
                // .then(()=>{
                //     console.log(response)
                // })
                // .catch(function(error){
                //     console.log(error);
                //     console.log('こんにちは')
                // })
                if(response.data.data == ''){
                    this.message = true;
                }else{
                    this.message = false;
                }
                this.data = response.data.data;
                console.log(this.data);
        }
    },

    computed:{
        test(){
            this.last_day = moment(this.month).endOf('month');
            this.day = moment(this.month).startOf('month');
            let list = [];

            while(moment(this.day).isBefore(this.last_day)){
                list.push(this.day.format('YYYY-MM-DD'));
                this.day = moment(this.day).add(1,'d');
            }
            return list;
        },
    },
    created(){
        this.getData();
    }
}
</script>