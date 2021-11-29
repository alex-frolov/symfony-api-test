FROM nginx:latest

RUN apt-get update && apt-get install -y \
    telnet

CMD ["nginx", "-g", "daemon off;"]
