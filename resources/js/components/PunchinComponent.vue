<template>
    <div class="content">
        <h2>{{message}}</h2>
        <h2 v-if="finStatus">本日の打刻は完了しております。お疲れ様でした！</h2>
        <div class="content_punch" >
            <p v-if="punchInStatus" @click="punchIn">勤務開始</p>
            <p v-else class="inactive">勤務開始</p>
            <p v-if="punchOutStatus" @click="punchOut" >勤務終了</p>
            <p v-else class="inactive">勤務終了</p>
        </div>
        <div class="content_break">
            <p v-if="breakInStatus" @click="breakIn">休憩開始</p>
            <p v-else class="inactive">休憩開始</p>
            <p v-if="breakOutStatus" @click="breakOut">休憩終了</p>
            <p v-else class="inactive">休憩終了</p>
        </div>
    </div>
</template>

<script>
export default {
    props:['user_id'],
    
    data(){
        return {
            punchInStatus:true,
            punchOutStatus:false,
            breakInStatus:false,
            breakOutStatus:false,
            finStatus:false,
            message:'',
        }
    },
    methods:{
        // 出勤打刻
        async punchIn(){
            const sendData = {
                user_id:this.user_id
            }
            const response = await axios.post("http://localhost:8000/api/attendance",sendData);
            this.punchInStatus = false;
            this.punchOutStatus = true;
            this.breakInStatus = true;
            this.message ='出勤しました！'
        },

        //退勤打刻
        async punchOut(){
            const id = this.user_id;
            const response = await axios.put("http://localhost:8000/api/attendance/"+id);
            console.log(response.data);
            this.punchInStatus = false;
            this.punchOutStatus = false;
            this.breakInStatus = false;
            this.breakOutStatus =false;
            this.message = '退勤しました！'
        },

        // 休憩入り
        async breakIn(){
            const sendData ={
                user_id:this.user_id,
            }
            const response = await axios.post("http://localhost:8000/api/breaktime",sendData);
            this.message = response.data.message
            this.breakInStatus = false;
            this.breakOutStatus = true;
            this.punchOutStatus = false;
        },

        //休憩戻り
        async breakOut(){
            const id = this.user_id;
            const response = await axios.put("http://localhost:8000/api/breaktime/"+id);
            this.message = response.data.message;
            this.breakInStatus = true;
            this.breakOutStatus = false;
            this.punchOutStatus = true;
        },

        // ステータスチェック
        async checkPunch(){
            const response = await axios.get("http://localhost:8000/api/checkattendance",{params:{user_id:this.user_id}});
            this.punchInStatus = response.data.punchIn;
            this.punchOutStatus = response.data.punchOut;
            this.breakInStatus = response.data.breakIn;
            this.breakOutStatus = response.data.breakOut;
            this.finStatus = response.data.fin;
        },
    },
    created(){
        this.checkPunch();
    }
}
</script>

<style scoped>
p {
    width: 45%;
    text-align: center;
    line-height: 150px;
    height: 150px;
    margin: 0;
    font-size: 2rem;
    background-color:#fff;
    
}

.content {
    background-color:#cccccc;
    padding:30px;
    font-family:"游ゴシック","ヒラギノ丸ゴ Pro",sans-serif;
    
}

.content_punch {
    display:flex;
    justify-content:space-between;
    width:80%;
    margin:35px auto;
    

}

.content_break { 
    display:flex;
    justify-content:space-between;
    width:80%;
    margin:auto;
}

.inactive {
    color:#eeeeee;
}


</style>