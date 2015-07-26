//Device code:
//Device code from SparkFun Wireless Communication is modified as required

local rxLEDToggle = 1; 
local txLEDToggle = 1;
arduino <- hardware.uart57;
rxLed <- hardware.pin8;
txLed <- hardware.pin9;
input_string <- ""


// Below function handles the UART initialization and callback
function initUart()
{
    hardware.configure(UART_57);    // Using UART on pins 5 and 7
    // 19200 baud works well, no parity, 1 stop bit, 8 data bits.
    // Provide a callback function, serialRead, to be called when data comes in:
    arduino.configure(4800, 8, PARITY_NONE, 1, NO_CTSRTS, serialRead);
}

// serialRead() will be called whenever serial data is passed to the imp. It
//  will read the data in, and send it out to the agent.
function serialRead()
{
  //  server.log("Data received on IMP serial input");
    local c = arduino.read(); // Read serial char into variable c

        if (c == -1) return
    
    if (c == 13)
    {
        // Carriage return received? Output the string and clear it for the next input
    
    //    server.log("Sent string: " + input_string)
        agent.send("agentsentdata", input_string);
    //    server.log("agentsenddata: "+input_string)
        input_string = ""
        toggleRxLED(); 
    }
    else
    {
        // Add the input character to the buffer
        
        input_string = input_string + chr(c)
         toggleRxLED(); 
    }

}
function chr(asciiValue)
{
    // Convert passed integer value Ascii code into a character string
    
    if (asciiValue < 32) return ""
        return format("%c", asciiValue)
}


// agent.on("dataToSerial") will be called whenever the agent passes data labeled
//  "dataToSerial" over to the device. This data should be sent out the serial
//  port, to the Arduino.
agent.on("dataToSerial", function(c)
{
    server.log("Agent sent data to IMP device");
    //arduino.write(c.tointeger()); // Write the data out the serial port.
    arduino.write(c);
    toggleTxLED(); // Toggle the TX LED indicator
});

// initLEDs() simply initializes the LEDs, and turns them off. Remember that the
// LEDs are active low (writing high turns them off).
function initLEDs()
{
    // LEDs are on pins 8 and 9 on the irmp Shield. Configure them as outputs,
    //  and turn them off:
    rxLed.configure(DIGITAL_OUT);
    txLed.configure(DIGITAL_OUT);
    rxLed.write(1);
    txLed.write(1);
}

// This function turns an LED on/off quickly on pin 9.
// It first turns the LED on, then calls itself again in 50ms to turn the LED off
function toggleTxLED()
{
    txLEDToggle = txLEDToggle?0:1;    // toggle the txLEDtoggle variable
    if (!txLEDToggle)
    {
        imp.wakeup(0.05, toggleTxLED.bindenv(this)); // if we're turning the LED on, set a timer to call this function again (to turn the LED off)
    }
    txLed.write(txLEDToggle);  // TX LED is on pin 8 (active-low)
}

// This function turns an LED on/off quickly on pin 8.
// It first turns the LED on, then calls itself again in 50ms to turn the LED off
function toggleRxLED()
{
    rxLEDToggle = rxLEDToggle?0:1;    // toggle the rxLEDtoggle variable
    if (!rxLEDToggle)
    {
        imp.wakeup(0.05, toggleRxLED.bindenv(this)); // if we're turning the LED on, set a timer to call this function again (to turn the LED off)
    }
    rxLed.write(rxLEDToggle);   // RX LED is on pin 8 (active-low)
}


server.log("Serial Pipeline Open!"); // A warm greeting to indicate we've begun
initLEDs(); // Initialize the LEDs
initUart(); // Initialize the UART


// From here, all of our main action will take place in serialRead() and the
// agent.on functions. It's all event-driven.
