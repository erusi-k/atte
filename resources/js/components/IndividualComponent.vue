<template>
    <div>
        <h2>個人別実績一覧</h2>
        <div class="month">
            <img class="month_sub" src="/images/ya.png" @click="subtractMonth">
            <p class="month_display">{{month.format('YYYY年MM月')}}</p>
            <img class="month_add" src="/images/ya.png" @click="addMonth">
            
        </div>
        <p class="content-message" v-if="message">実績がありません。</p>

        <table v-else>
            <tr>
                <th>日付</th>
                <th>出勤時間</th>
                <th>退勤時間</th>
                <th>休憩時間</th>
                <th>勤務時間</th>
            </tr>
            <tr v-for="item in dataList" :key="item.id">
                <th>{{item.day}}</th>
                <th>{{item.punchIn}}</th>
                <th>{{item.punchOut}}</th>
                <th>{{item.break}}</th>
                <th>{{item.total}}</th>
            </tr>
        </table>
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
            data:[],
            message:false,
        }
    },
    methods:{
        
        // 月の追加
        addMonth(){
            this.month = moment(this.month).add(1,'month');
            this.getData();
        },

        // 月の減算
        subtractMonth(){
            this.month = moment(this.month).subtract(1,'month');
            this.getData();
        },

        // 実績データ取得
        async getData(){
            await axios.get("https://whispering-wildwood-63075.herokuapp.com/api/individual",{params:{user_id:this.user_id,day:this.month.format('YYYY-MM')}})
            .then((response) => {
                this.data = response.data.data;
                if(response.data.data == ''){
                    this.message = true;
                }else{
                    this.message = false;
                }
            })
            .catch((error) => {
                console.log(error);
                alert('通信に失敗しました。もう一度お試しください。')
            })
        }
    },

    computed:{
        // 日付ごとにデータ表示
        dataList(){
            this.last_day = moment(this.month).endOf('month');
            this.day = moment(this.month).startOf('month');
            let i = 0;
            let list = [];
            

            while(moment(this.day).isBefore(this.last_day)){
                
                let day = this.day.format('YYYY-MM-DD')
                this.data.forEach((item) =>{
                    if(day == item.day){
                        list.push({
                            'day': this.day.format('YYYY年MM月DD日'),
                            'punchIn':item.punchIn,
                            'punchOut':item.punchOut,
                            'break':item.break,
                            'total':item.total
                            });
                    }
                }) 
                if(!list[i]){
                    list.push({
                            'day': this.day.format('YYYY年MM月DD日'),
                            'punchIn':'---',
                            'punchOut':'---',
                            'break':'---',
                            'total':'---'
                            });
                }    
                i++;    
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

<style scoped>

img { 
    display:block;
    width:20px;
    height:20px;
}

.content-message {
    text-align: center;
}

.month {
    display: flex;
    justify-content: center;
    align-items: center;
}

.month_display{ 
    margin:65px 30px
}

.month_sub {
    transform: scale(-1,1);
}


table {
    border-collapse: collapse;
    border-spacing: 5px;
    margin: 0 auto;
    padding: 0;
    width: 90%;
    margin-left: auto;
    margin-right: auto;

}

table th,
table td {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

table th {
    padding: 15px 0;
    font-size: 14px;
    text-align: center;
}
table tr{
    text-align: center;
    padding: 20px 0;
    background-color: #fff;
    color:#000000;
}

@media screen and (max-width:600px){
    

    table td{
        font-size:5px
    }
}    
</style>


