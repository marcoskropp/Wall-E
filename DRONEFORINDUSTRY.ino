
#include <Servo.h>
#include <ESP8266WiFi.h>

Servo m_direito;
Servo m_esquerdo;

//Nome da sua rede Wifi
const char* ssid = "Industry1";

//Senha da rede
const char* password = "oisenailuzerna10";

//IP do ESP (para voce acessar pelo browser)
//10.3.119.253
IPAddress ip(10, 3, 118, 201);

//IP do roteador da sua rede wifi
IPAddress gateway(10, 3, 119, 253);

//Mascara de rede da sua rede wifi
IPAddress subnet(255, 255, 252, 0);

//Criando o servidor web na porta 80
WiFiServer server(80);

//Funcao que sera executada apenas ao ligar o ESP8266
void setup()
{
  //Preparando o GPIO2, que esta lidago ao LED
  pinMode(12, OUTPUT);
  pinMode(13, OUTPUT);
  digitalWrite(12, 1);
  digitalWrite(13, 1);

  //Conectando a� rede Wifi
  WiFi.config(ip, gateway, subnet);
  WiFi.begin(ssid, password);
  Serial.begin(9600);
  //Verificando se esta conectado,
  //caso contrario, espera um pouco e verifica de novo.
  while (WiFi.status() != WL_CONNECTED)
  {
    Serial.print("caiu");
    delay(500);
  }

  //Iniciando o servidor Web
  server.begin();

  m_direito.attach(13);
  m_esquerdo.attach(12);
}

//Funcao que sera executada indefinidamente enquanto o ESP8266 estiver ligado.
void loop()
{
  char arr[] = {'0', '1', '2', '3', '4', '5', '6', '7', '8', '9'};
  int i = 0, o = 0;
  String mi = "Milhar", ce = "Centena", de = "Dezena", un = "Unidade";
  String miB = "Milhar", ceB = "Centena", deB = "Dezena", unB = "Unidade";
  float milhar = -1.0, centena = - 1.0, dezena = -1.0, unidade = -1.0;
  WiFiClient client = server.available();
  if (!client)
  {
    Serial.print("client\n");
    return;
  }

  //Verificando se o servidor recebeu alguma requisicao
  while (!client.available())
  {
    Serial.print("cl\n");
    delay(1);
  }
  //Obtendo a requisicao vinda do browser
  String req = client.readStringUntil('\r');
  client.flush();

  //Iniciando o buffer que ira conter a pagina HTML que sera enviada para o browser.
  String buf = "";

  buf += "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\n\r\n<!DOCTYPE HTML>\r\n<html>\r\n";
  buf += "<head><meta http-equiv=''Acess-Control-Allow-Origin' content='*'><meta http-equiv=""refresh"" content=""3""></head><body>";
  buf += "<h3>ESP8266 Servidor Web</h3>";
  buf += "<p>LED <a href=\"?function=www\"><button>LIGA</button></a><a href=\"?function=jjj \"><button>DESLIGA</button></a></p>";
  buf += "</body></html>\n";

  //Enviando para o browser a 'pagina' criada.
  client.print(buf);
  client.flush();


  //Analisando a requisicao recebida para decidir se liga ou desliga o LED
if (req.indexOf("www") != -1) {
      unidade =  1;
      dezena = 0;
      centena = 0;
      milhar = 0;
      ///  Serial.print("Milhar ");
      //  Serial.println(milhar);
    } else
    {
      client.stop();
    }
  //   Serial.println("teste2");

  for (i = 0; i < 10 ; i++) {
    miB += arr[i];
    ceB += arr[i];
    deB += arr[i];
    unB += arr[i];
    if (req.indexOf(miB) != -1) {
      milhar = i * 1000;
      ///  Serial.print("Milhar ");
      //  Serial.println(milhar);
    } else
    {
      client.stop();
    }
    if (req.indexOf(ceB) != -1) {
      centena = i * 100;
      // Serial.print("Centena  ");
      // Serial.println(centena);
    } else
    {
      client.stop();
    }

    if (req.indexOf(deB) != -1) {
      dezena = i * 10;
      // Serial.print("Dezena ");
      // Serial.println(dezena);
    } else
    {
      client.stop();
    }
    if (req.indexOf(unB) != -1) {
      unidade = i;
      // Serial.print("Unidade ");
      // Serial.println(unidade);
    } else
    {
      client.stop();
    }
    miB = mi;
    ceB = ce;
    deB = de;
    unB = un;
  }






  if (milhar != -1 && centena != -1 && dezena != -1 && unidade != -1) {
    //  Serial.println("foi");

    float metros = milhar + centena + dezena + unidade;
    float tempo = 7500; //milesimo      tempo para andar 1 metro
    float tempoTotal = metros * tempo;
    m_direito.write(70);
    m_esquerdo.write(0); //frente
    delay(tempoTotal);
    m_direito.write(92); //para
    m_esquerdo.write(92);
    delay(7000); //espera
    m_direito.write(0);
    m_esquerdo.write(92);//gira
    delay(4800);
    m_direito.write(92);
    m_esquerdo.write(92);
    m_direito.write(70);//volta
    m_esquerdo.write(0);
    delay(tempoTotal);
    m_direito.write(92);
    m_esquerdo.write(0);//gira
    delay(4800);
    m_direito.write(92);
    m_esquerdo.write(92);
  }
  else {
    Serial.println("Nao foi");
    client.stop();
  }

}


