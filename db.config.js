const mysql=require("mysql")


const conx=mysql.createConnection({
    host : '192.168.5.252', 
    user : "Admin",
    password :"Asterisk%2022%",
    database : "astdb",
    dateStrings: true
}) ; 



conx.connect((error) => {
    if (error) throw error  
    console.log("====> Database Connected.")
    
    
})



module.exports=conx ;
