FROM node:14

WORKDIR /Coursework-6--3y/react-laravel-front

COPY package*.json ./

RUN npm install

COPY . .

EXPOSE 3000

CMD ["npm", "start"]