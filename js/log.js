let message = {
    type: "",
    content: "",
};

if (!document.querySelector("script[src='js/log.js']")) {
    message.type = document.querySelector("script[src='../js/log.js']").getAttribute("name");
    message.content = document.querySelector("script[src='../js/log.js']").getAttribute("value");
} else {
    message.type = document.querySelector("script[src='js/log.js']").getAttribute("name");
    message.content = document.querySelector("script[src='js/log.js']").getAttribute("value");
}

if (message.type === "error") 
    console.warn(message.content);
else 
    console.log(message.content);
