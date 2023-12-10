#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>
#include "String.h"
int sensorAIN = 4;
int sensorAOUT = 6;
int sensorBIN = 5;
int sensorBOUT = 7;
int sensorEIN = 8;
int sensorEOUT = 10;
int lockA = 3;
int lockB = 9;
int lockE = 11;
//----------------------------------------SSID and Password of WiFi
const char* ssid = ""; 
const char* password = ""; 
String host_or_IPv4 = "http://localhost/";
String   Destination = "listener.php";
String URL_Server =host_or_IPv4+Destination;
HTTPClient http; //--> Declare object of class HTTPClient
WiFiClient client;
struct Slot {
  String label;
  String status;
  String gate_status;
};
String gate_status = "Closed";
struct Slot slot_A;
struct Slot slot_B;

//--------------B,C,D,E,F,G,H,I,J,K
void checkS(){
    if(digitalRead(sensorAIN)==0 && slot_A.status=="Active" && slot_A.gate_status == "Open"){
          digitalWrite(lockA, HIGH);
    } 
    if(digitalRead(sensorAIN)==1 && slot_A.status=="Active" && slot_A.gate_status =="Open"){
          digitalWrite(lockA, LOW);
          slot_A.gate_status == "Closed";
    } 
    if(digitalRead(sensorAOUT)==1 && slot_A.status=="Empty" && slot_A.gate_status == "Open"){
         digitalWrite(lockA, LOW);
          slot_A.gate_status == "Closed";
    } 
     if(digitalRead(sensorAOUT)==0 && slot_A.status=="Empty" && slot_A.gate_status == "Open"){
         digitalWrite(lockA, HIGH);
    } 
    if(digitalRead(sensorBIN)==0 && slot_B.status=="Active" && slot_B.gate_status == "Open"){
          digitalWrite(lockA, HIGH);
    } 
    if(digitalRead(sensorBIN)==1 && slot_B.status=="Active" && slot_B.gate_status =="Open"){
          digitalWrite(lockA, LOW);
          slot_B.gate_status == "Closed";
    } 
     if(digitalRead(sensorBOUT)==1 &&slot_B.status=="Empty" &&slot_B.gate_status == "Open"){
         digitalWrite(lockA, LOW);
         slot_B.gate_status == "Closed";
    } 
     if(digitalRead(sensorBOUT)==0 &&slot_B.status=="Empty" &&slot_B.gate_status == "Open"){
         digitalWrite(lockA, HIGH);
    } 
}

void checkG(){
if(digitalRead(sensorEIN)==1 && digitalRead(sensorEOUT)==0){
  if(gate_status=="Open"){
     digitalWrite(lockE,LOW);
     gate_status="closed";
  }
}
if(digitalRead(sensorEOUT)==1 && digitalRead(sensorEIN)==0){
  if(gate_status=="Open"){
     digitalWrite(lockE,LOW);
     gate_status="closed";
  }
}
}
void inspect(){
  checkG();
  checkS();
}
void setup() {
  slot_A = { "A", "Empty", "Closed" };
  slot_B = { "B", "Empty", "Closed" };

  pinMode(sensorAIN, INPUT);
  pinMode(sensorAOUT, INPUT);
  pinMode(sensorBIN, INPUT);
  pinMode(sensorBOUT, INPUT);
  pinMode(sensorEIN, INPUT);
  pinMode(sensorEOUT, INPUT);
  pinMode(lockA, OUTPUT);
  pinMode(lockB, OUTPUT);

  pinMode(lockE, OUTPUT);
  WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password); //--> Connect to wifi
   //Wait for connection
  Serial.print("Connecting");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    //--------------show connecting
    delay(250);
  }
}
void loop() {
  String param = "M_G="+gate_status+"&A_G="+slot_A.gate_status+"&A_S="+slot_A.status+"&B_G="+slot_B.gate_status+"&B_S="+slot_B.status;
  http.begin(client, URL_Server); //--> Specify request destination
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //Specify content-type header
  int httpCodeGet = http.POST(param); //--> Send the request
  String payload = http.getString(); //--> Get the response payload from server
  http.end(); //--> Close connection
   int i = 0;
  char info[payload.length()+1];
  strcpy(info,payload.c_str());
    char *p = strtok(info, ",");
    char *array[6];
    while (p != NULL)
    {
        array[i++] = p;
        p = strtok (NULL, ",");
    }
      if(!(digitalRead(sensorAIN)==0 && slot_A.status=="Active" && slot_A.gate_status == "Open")||
      !(digitalRead(sensorAOUT)==0 && slot_A.status=="Empty" && slot_A.gate_status == "Open")
      ){
           slot_A.gate_status=array[1];
           slot_A.status=array[2];

    } 
      if(!(digitalRead(sensorBIN)==0 && slot_B.status=="Active" && slot_B.gate_status == "Open")||
      !(digitalRead(sensorBOUT)==0 && slot_B.status=="Empty" && slot_B.gate_status == "Open")
      ){
           slot_B.gate_status=array[3];
             slot_B.status=array[4];

    }
     if(!(digitalRead(sensorEIN)==1 && digitalRead(sensorEOUT)==0)){
  if(!gate_status=="Open"){
     gate_status=array[0];
  }
  }
  inspect();
  delay(10000); //--> GET Data at every 10 seconds. 
}

