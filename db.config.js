const mysql=require("mysql")


const conx=mysql.createConnection({
    host : 'localhost', 
    user : "Admin",
    password :"%Pucelle6969",
    database : "ASTDB",
    dateStrings: true
}) ; 



conx.connect((error) => {
    if (error) throw error  
    console.log("====> Database Connected.")
    
    
})



module.exports=conx ;
