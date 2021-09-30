<template>
    <div>
        <p>{{message}}</p>
        <p v-if="inStatus" @click="punchIn();stechang()">出勤です！</p>
        <p v-else>出勤消えてます！</p>
        <p @click="punchOut">退勤です！</p>
        <p>{{user_id}}</p>
        <p @click="breakIn">休憩入り</p>
        <p @click="breakOut">休憩戻り</p>
        <p>{{attendanceId}}</p>
    </div>
</template>

<script>
export default {
    props:['user_id'],
    data(){
        return {
            inStatus:true,
            message:'',
            attendanceId:''

        }
    },
    methods:{

        async punchIn(){
            const sendData = {
                user_id:this.user_id
            }
            const response = await axios.post("http://localhost:8000/api/attendance",sendData);
            this.attendance_id=response.data.data.id;
        },
        async punchOut(){
            const id = this.user_id;
            const response = await axios.put("http://localhost:8000/api/attendance/"+id);
            console.log(response.data);
        },

        async breakIn(){
            const sendData ={
                user_id:this.user_id,
                attendance_id:this.attendanceId
            }
            const response = await axios.post("http://localhost:8000/api/breaktime",sendData);
            this.message = response.data.message
        },

        async breakOut(){
            const id = this.user_id;
            const response = await axios.put("http://localhost:8000/api/breaktime/"+id);
            this.message = response.data.message
        },

        async checkPunchIn(){
    
            const response = await axios.get("http://localhost:8000/api/checkattendance",{params:{user_id:this.user_id}});
            this.inStatus = response.data.time;
            console.log(response.data.id);
        },

        async getAttendanceId(){
            const response = await axios.get("http://localhost:8000/api/attendance",{params:{user_id:this.user_id}});
            this.attendanceId = response.data.data;
            console.log(response.data.data);
        },

        stechang(){
            this.inStatus = false
        }
    },
    created(){
        this.checkPunchIn();
        this.getAttendanceId();
    }
}
</script>