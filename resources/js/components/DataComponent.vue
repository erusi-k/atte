<template>
<div id="app">
    <h2>日付別実績一覧</h2>
    <div class="content">
        <div class="day"  @click="requestData">
            <img class="day_sub" src="/images/ya.png" @click="subtractDay">
            <p class="day_display">{{day.format('YYYY年MM月DD日')}}</p>
            <img class="day_add" src="/images/ya.png" @click="addDay">
            </div>
        <p class="content-message" v-if="message">実績がありません。</p>
        <table v-else>
            <tr>
                <th>名前</th>
                <th>勤務開始時間</th>
                <th>勤務終了時間</th>
                <th>休憩時間</th>
                <th>勤務時間</th>
            </tr>
            
            <tr  v-for="data in datas" :key="data.id">
                <td>{{data.name}}</td>
                <td>{{data.punchIn}}</td>
                <td>{{data.punchOut}}</td>
                <td>{{data.break}}</td>
                <td>{{data.total}}</td>
            </tr>
        </table>
    </div>
    <!-- ページーネーション処理 -->
    <div v-if="pageCheck" class="pagination">
        <ul class="pagination_content">
            <li class="inactive" :class="(current_page == 1) ? 'disabled':''" @click ="changePage(current_page-1)">«</li>
            <li v-for="page in frontPageRange" :key="page" @click="changePage(page)" :class="(isCurrent(page)) ? 'active':'inactive'">{{page}}</li>
            <li v-show="front_dot" class="inactive disabled">...</li>
            <li v-for="page in middlePageRange" :key="page" @click="changePage(page)" :class="(isCurrent(page)) ? 'active':'inactive'">{{page}}</li>
            <li v-show="end_dot" class="inactive disabled">...</li>
            <li v-for="page in endPageRange" :key="page" @click="changePage(page)" :class="(isCurrent(page))? 'active':'inactive'">{{page}}</li>
            <li class="inactive" :class="(current_page >= last_page) ? 'disabled':''" @click="changePage(current_page+1)">»</li>
        </ul>
    </div>
</div>
</template>

<script>
import moment from "moment";

export default {
    data(){
        return {
            day:moment(),
            datas:'',
            current_page:1,
            last_page:'',
            range:5,
            front_dot:false,
            end_dot:false,
            end:false,
            message:true,
            size:8,
        }
    },
    created(){
        this.requestData();
    },
    computed:{
        frontPageRange(){
            if(!this.sizeCheck){
                return this.calRange(1,this.last_page);
            }
            return this.calRange(1,2);
        },
        middlePageRange(){
            let start = "";
            let end = "";
            if(!this.sizeCheck){
                this.front_dot = false;
                this.end_dot = false;
                return [];
            }
            if(this.current_page <= this.range){
                start = 3;
                end = this.range +2;
                this.front_dot = false;
                this.end_dot = true;
            }else if (this.current_page > this.last_page - this.range){
                start = this.last_page - this.range -1;
                end = this.last_page - 2;
                this.front_dot = true;
                this.end_dot = false;
            } else {
                start = this.current_page - Math.floor(this.range / 2);
                end = this.current_page + Math.floor(this.range / 2);
                this.front_dot = true;
                this.end_dot = true;
            }
            return this.calRange(start,end);
        },
        endPageRange(){
            if(!this.sizeCheck){
                return [];
            }
            return this.calRange(this.last_page -1, this.last_page);
        },
        sizeCheck(){
            if(this.last_page < this.size) {
                return false;
            }
                return true;
        },
        pageCheck(){
            if(this.last_page == 1){
                return false;
            }
                return true;
        }
        
    },

    methods:{
        // 日付1日追加
        addDay(){
            let day = moment(this.day);
            this.day = day.add(1,'days');
        },

        // 日付1日削除
        subtractDay(){
            let day = moment(this.day);
            this.day = day.subtract(1,'days');
        },

        // 実績データ取得処理
        async requestData(){
            let item = this.day.format('YYYY-MM-DD')
            await axios.get(`https://whispering-wildwood-63075.herokuapp.com/api/datarequest?page=${this.current_page}`,{params:{day:item}})
            .then((response) => {
                this.datas = response.data.data.data;
            if(response.data.data.data.length >0){
                this.message = false;
            }else{
                this.message = true;
            }
            this.current_page = response.data.data.current_page;
            this.last_page = response.data.data.last_page;
            })
            .catch((error) => {
                console.log(error);
                alert('通信に失敗しました。もう一度お試しください。')
            })
        },

        calRange(start,end){
            const renge = [];
            for(let i = start;i <= end; i++){
                renge.push(i);
            }
            return renge;
        },
        changePage(page){
            if(page > 0 && page <= this.last_page){
                this.current_page = page;
                this.requestData();
            }
        },
        isCurrent(page){
            return page === this.current_page;
        },
    }

}
</script>

<style scoped>

/* ページーネーションのスタイル */
.pagination {
    width:100%;
    margin:65px 0;
    
    
}

.pagination_content {
    display:flex;
    list-style-type:none;
    width:80%;
    justify-content: center;
    padding-left: 0;
    
}
.pagination_content li {
    border:1px solid #ddd;
    padding:6px 12px;
    text-align: center;
}



.active {
    background-color:aqua;
}



.disabled { 
    cursor:not-allowed;
}

#app {
    width: 100%;
    font-family:"游ゴシック","ヒラギノ丸ゴ Pro",sans-serif;
}

h2 {
    text-align: center;
}

img { 
    display:block;
    width:20px;
    height:20px;
}

ul { 
    margin:auto;
}

.content {
    width:100%;
}

.day {
    display: flex;
    justify-content: center;
    align-items: center;
}

.day_display{ 
    margin:65px 30px
}

.day_sub {
    transform: scale(-1,1);
}

.content-message {
    text-align: center;
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
        font-size:10px
    }
}



</style>

