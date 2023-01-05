let messageContent = document.querySelector("script[src='js/log.js']").getAttribute("value");
let messageType = document.querySelector("script[src='js/log.js']").getAttribute("name");

if (!messageContent) 
    messageContent = document.querySelector("script[src='../js/log.js']").getAttribute("value");
if (!messageType) 
    messageContent = document.querySelector("script[src='../js/log.js']").getAttribute("name");

if (messageType === "error") 
    console.error(messageContent);
else if (messageType === "warning")
    console.warn(messageContent);
else 
    console.log(messageContent);
