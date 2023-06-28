FROM node:14.15.3-alpine AS production

WORKDIR /usr/src/app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm install -g @nestjs/cli

#RUN apt install vim

#RUN npm run build

EXPOSE ${PORT}

CMD ["npm", "run", "start:prod"]
