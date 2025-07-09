function sleep(milliseconds) {
  const start = Date.now();
  while (Date.now() - start < milliseconds) {
    // Busy-waiting
  }
}

console.log("Adi")

setTimeout(()=>{
    console.log("Pranav");
},5500);

sleep(10000); 

console.log("Tirth");