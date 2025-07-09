// BASIC

async function handlepromise(){
    return "adi";
}
const datapromise = handlepromise();
datapromise.then(res=> console.log(res));


async function handlepromise(){
    return "adi";
}
handlepromise().then(res=> console.log(res));



// USING PROMISE

const p = new Promise((resolve,reject)=>{
    resolve("Adi is resolved");
})
function handlepromise(){
    p.then(res=> console.log(res));
}
handlepromise();



// USING ASYNC AWAIT

const p = new Promise((resolve,reject)=>{
    resolve("Adi is resolved");
})
async function handlepromise(){
    const val = await p;
    console.log(val);
}
handlepromise();



// USING SETTIMEOUT , PROMISE

const p = new Promise((resolve,reject)=>{
    setTimeout(()=>{
        resolve("Adi is resolved");
    },5000)
})
// JS engine was not waiting for the promise to get resolved
function handlepromise(){
    p.then(res=> console.log(res));
    console.log("Adi JS")
}
handlepromise();



// USING SETTIMEOUT , ASYNC AWAIT

const p = new Promise((resolve,reject)=>{
    setTimeout(()=>{
        resolve("Adi is resolved");
    },5000)
})
// JS waits for promise to be resolved
async function handlepromise(){
    console.log("Adi Zoom")
    const val = await p;
    console.log("Adi JS");
    console.log(val);
}
handlepromise();



// ONE PROMISE TWO TIMES RESOLVED

const p = new Promise((resolve,reject)=>{
    setTimeout(()=>{
        resolve("Adi is resolved");
    },5000)
})
// JS waits for promise to be resolved
async function handlepromise(){
    console.log("Adi Zoom")
    
    const val1 = await p;
    console.log("Adi JS1");
    console.log(val1);

    const val2 = await p;
    console.log("Adi JS2");
    console.log(val2);
}
handlepromise();



// TWO PROMISES TWO TIMES RESOLVED 

const p1 = new Promise((resolve,reject)=>{
    setTimeout(()=>{
        resolve("Adi is resolved by p1");
    },5000)
})
const p2 = new Promise((resolve,reject)=>{
    setTimeout(()=>{
        resolve("Adi is resolved by p2");
    },10000)
})
// JS waits for promise to be resolved
async function handlepromise(){
    console.log("Adi Zoom")
    
    const val1 = await p1;
    //const val1 = await p2;
    console.log("Adi JS1");
    console.log(val1);

    const val2 = await p2;
    //const val2 = await p1;
    console.log("Adi JS2");
    console.log(val2);
}
handlepromise();



const p1 = new Promise((resolve,reject)=>{
    setTimeout(()=>{
        resolve("Adi is resolved by p1");
    },10000)
})
const p2 = new Promise((resolve,reject)=>{
    setTimeout(()=>{
        resolve("Adi is resolved by p2");
    },5000)
})
// JS waits for promise to be resolved
async function handlepromise(){
    console.log("Adi Zoom")
    
    const val1 = await p1;
    //const val1 = await p2;
    console.log("Adi JS1");
    console.log(val1);

    const val2 = await p2;
    //const val2 = await p1;
    console.log("Adi JS2");
    console.log(val2);
}
handlepromise();


// Fetch API

const API_URL = "https://api.github.com/users/Adiking117";
async function handlepromise(){
    const val = await fetch(API_URL);
    const jsonval = await val.json();
    console.log(jsonval);
}
handlepromise();


const API_URL = "https://api.github.com/users/Adiking117";
//const API_URL = "https://api.giub.codiking117";
async function handlepromise(){
    try{
        const val = await fetch(API_URL);
        const jsonval = await val.json();
        console.log(jsonval);
    }catch(err){
        console.log(err);
    }
}
handlepromise();

