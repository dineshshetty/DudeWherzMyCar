//Agent code:

//Agent code from SparkFun Wireless Communication is modified as required


// The URL of the other Imp's agent:
const agentURL =  “https://agent.electricimp.com/<placeagentconstanthere>”;
const gpswebURL = “http://<yourserverip>/Bp6Kv5Ccr3hzRk7sNbE775Xead5FmBfp4jsLyu_savelocation.php”;


// When the imp sends data to the agent, that data needs to be relayed to the
// other agent. We need to construct a simple URL with a parameter to send
// the data.

device.on("agentsentdata", function(char2)
{
    server.log("Data sent by device: "+char2);
    local urlSend = format("%s?location=%s", gpswebURL, char2);
    http.get(urlSend).sendasync(function(resp){});
  });

// The request handler will be called whenever this agent receives an HTTP
// request. We need to parse the request, look for the key "data". If we 
// found "data", send that value over to the imp.
function requestHandler(request, response)
{
    try
    {
        // Check for "data" key.
        if ("data" in request.query)
        {
            // If we see "data", send that value over to the imp.
            // Label the data "dataToSerial" (data to serial output).
            //device.send("dataToSerial", request.query.data);
            server.log("Data sent by url: "+request.query.data);
            device.send("dataToSerial", "Why no workss!!");
        }
        // send a response back saying everything was OK.
        response.send(200, "OK");
    }
    catch (ex)  // In case of an error, produce an error code.
    {
        response.send(500, "Internal Server Error: " + ex);
    }
}

// Register our HTTP request handler. requestHandler will be called whenever
// an HTTP request comes in.
http.onrequest(requestHandler);
