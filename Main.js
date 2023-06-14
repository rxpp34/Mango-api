const express=require("express") ; 
const app=express() ;
const fs = require('fs')
const path = require('path');
const conx=require("./db.config")
const cors = require('cors');
const { exec } = require('child_process');
const port=8080 ; 

app.use(cors())
app.use(express.json()) ; 


app.get("/GetAllContact", (req, res) => {
    conx.query("SELECT * from Contact ORDER BY NAME ASC",(err,result) => {
        if (err) throw err ; 
        res.send(result) ;
    })
})

app.get("/GetHistoricall/:sip",(req,res) => {
    conx.query("SELECT * FROM historicall WHERE sip=? ORDER BY id DESC LIMIT 5", [req.params.sip],(err,result) => {
        if (err) throw err ;
        res.send(result)  ;
    })
})

app.get("/GetAllCall",(req,res) => {
    conx.query("SELECT * FROM ALLCALLS", (err, result) => {
        if (err) throw err ;
        res.send(result)  ;
    })
})

app.post("/PerformCall/:from/:num/:name", (req,res) => {
    exec('php ./PerformCall.php '+req.params.from+' '+req.params.num+' '+req.params.name, (error, stdout, stderr) => {
        if (error) {
          console.error(`Erreur lors de l'exécution du script PHP : ${error}`);
          return;
        }
        
        if(stdout==="OK")
        {
            res.send("OK")
        }
      });

})


app.post("/DeleteContact/:ID",(req,res) => {
    conx.query("DELETE FROM Contact WHERE id=?", req.params.ID,(err, result) => {
        if (err) throw err ;
        res.send("OK")  ;
    })
})

app.post("/AddContact/:nom/:num",(req,res) => {
    conx.query("INSERT INTO Contact (Name,Phone) VALUES (?,?)",[req.params.nom,req.params.num],(err, result) => {
        if (err) throw err ;
        res.send("OK")  ;
    })
})


app.get("/astdb_xml",(req,res) => {
    const filePath = './astdb.xml';
    res.sendFile(path.resolve(filePath));
})

app.post("/RefreshXML",(req,res) => {
    exec('php ./RefreshXml.php', (error, stdout, stderr) => {
        if (error) {
          console.error(`Erreur lors de l'exécution du script PHP : ${error}`);
          return;
        }
        
        if(stdout==="OK")
        {
            res.send("OK")
        }
      });
})


app.listen(port , console.log("====> Server Listening on "+port))
 