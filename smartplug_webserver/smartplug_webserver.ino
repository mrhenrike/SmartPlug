/*
 * Arquivo:   smartplug_webserver.ino
 * Tipo:      Codigo-fonte para utilizar no NodeMCU atraves da IDE do Arduino
 * Autor:     André Henrique
 * Descricao: Sketch para utilizar no projeto Smart Plug da União Geek: um disjuntor para 04 tomadas, controlado via aplicação web com php.
 * Data:      24 SET 2018
*/

#include <ESP8266WiFi.h>

//Nome da rede Wifi
const char* ssid = "UniaoGeek";

//Chave da rede Wifi
const char* password = "geek@uniao";

//IP do ESP (ip que irá receber as requisições de comandos liga/desliga)
IPAddress ip(192, 168, 0, 100);

//IP do roteador da rede wifi
IPAddress gateway(192, 168, 0, 1);

//Mascara de rede da sua rede wifi
IPAddress subnet(255, 255, 255, 0);

//Criando o webserver na porta 80
WiFiServer server(80);

//Pino do NodeMCU que estará conectado ao rele
const int rele[] = {D1, D2, D3, D4}; //Define pinos digitais do NodeMCU para conexao dos reles
#define numReles (sizeof(rele)/sizeof(char *)) //Quantidade de reles definidos

//Funcao que sera executada ao ligar o NodeMCU
void setup() {
  Serial.begin(115200); //Inicializa a serial para auditoria do dispositivo
  delay(10); //Intervalo de 10 milisegundos
  
  //Todos os reles vão inicar desligados
  for (int i=0; i < numReles; i++){
    pinMode(rele[i], OUTPUT);
    digitalWrite(rele[i], HIGH);
  }
 
  //Abaixo seguem configurações de starter do webserver
  //Conectando a rede Wifi
  WiFi.config(ip, gateway, subnet);
  WiFi.begin(ssid, password);
  
  //Verificando se esta conectado, caso contrario, espera um pouco e verifica de novo.
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
  }

  //Iniciando o webserver
  server.begin();
}

//Funcao que sera executada indefinidamente enquanto o NodeMCU estiver ligado.
void loop() {
  //Verificando se o server esta pronto.
  WiFiClient client = server.available();
  if (!client) {
    return;
  }

//  Serial.println("Novo cliente conectado");
//  //Verificando se o server recebeu alguma requisicao
//  while (!client.available()) {
//    delay(1);
//  }

  //Obtendo a requisicao vinda do browser
  String req = client.readStringUntil('\r');  
  Serial.println(req); //Escreve a requisicao na serial
  
  //Analisando a requisicao recebida para decidir se liga ou desliga um rele
  for (int i=0; i < numReles; i++){
    String comOn = "OL"; comOn += i; comOn += "_ON";
    String comOff = "OL"; comOff += i; comOff += "_OFF";

    if (req.indexOf(comOn) != -1){digitalWrite(rele[i], LOW);}
    else if (req.indexOf(comOff) != -1){digitalWrite(rele[i], HIGH);}
  
    //Analisando a requisicao recebida para verificar se desliga/liga todos os reles
    else if (req.indexOf("OLALL_ON") != -1){digitalWrite(rele[i], LOW);}
    else if (req.indexOf("OLALL_OFF") != -1){digitalWrite(rele[i], HIGH);}
  
    Serial.print("Rele ");
    Serial.print(i);
    Serial.print(": ");
    Serial.println(not(digitalRead(rele[i])));
    
    //Enviando para o browser o retorno com estado dos reles.
//    String buf = "";
//    buf += not(digitalRead(rele[i]));
//    buf += "\n";
//    client.print(buf);
    //client.flush(); //Aguarda ate que todos os dados tenham sido enviados. Gera delay na conexao com novas requisicoes
  }
  
  client.stop(); //Fecha a conexao ao fim do loop
  Serial.println("Cliente desconectado");
}