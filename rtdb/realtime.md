# Firebase Realtime Database

Base de datos alojada en la nube en la que los datos se almacenan como JSON.
Los datos se sincronizan en tiempo real con cada cliente conectado.

Todos los clientes comparten una instancia de Realtime Database y reciben automáticamente actualizaciones con los datos más recientes cuando se crean aplicaciones multiplataforma.

### Crear una bbdd Realtime

Desde la consola de Firebase seleccionamos la opción de `Developers-> Database`.  En este caso podremos elegir entre dos opciones **cloud Firestore** y **Real-time database**.

  Seleccionamos la opción crear bbdd Realtime y en Security rules utilizamos la opción *Start in test mode*.


### Reglas de seguridad

Mediante un lenguaje de reglas declarativas se definen cómo se deben estructurar los datos, cómo se deben indexar y cuándo se pueden leer y escribir.

De forma predeterminada, el acceso de lectura y escritura a la base de datos está restringido, por lo que solo los usuarios autenticados pueden leer o escribir datos.

Para comenzar sin configurar la autenticación, se pueden crear unas reglas de acceso público, con las que cualquier usuario puede acceder en modo de lectura y escritura a la bbdd.

```json
{
  "rules": {
    ".read": true,
    ".write": true
  }
}
```

Para permitir que accedan únicamente usuarios autenticados:

```json
{
  "rules": {
    ".read":  "auth!=null",
    ".write": "auth!=null"
  }
}
```
Desde la pestaña `rules` se realizan los cambios.

### Estructura de datos

Para estructurar bien los datos se requiere planificar cómo se guardarán los datos y cómo se recuperarán, para que el proceso sea lo más fácil posible.

- Los datos en Realtime, se almacenan como **objetos JSON**.
- **No hay tablas ni registros**, lo que significa que es una base de datos NoSQL.
- Los datos se pueden representar como tipos nativos JSON.
- Los datos del árbol JSON, se convierte en un nodo en la estructura JSON existente con una clave asociada.
- Podemos proporcionar nuestras propias claves, como ID de usuario o nombres, o se nos pueden proporcionar mediante la función `push()`.

Ejemplo de almacenamiento de datos para una aplicación de chat:
     - Esta aplicación de chat permite a los usuarios almacenar el perfil básico y la lista de contactos.
     - El perfil de usuario se ubicaría en una ruta como Usuarios / $ uid. El usuario es un nodo en él y tendrá una especie de clave primaria asociada con una ID. Entonces, podemos acceder a cada uno de forma única.

```json
{
  // This is a poorly nested data architecture, because iterating the children
  // of the "chats" node to get a list of conversation titles requires
  // potentially downloading hundreds of megabytes of messages
  "chats": {
    "one": {
      "title": "Historical Tech Pioneers",
      "messages": {
        "m1": { "sender": "ghopper", "message": "Relay malfunction found. Cause: moth." },
        "m2": { ... },
        // Obtener una lista de los títulos de conversaciones de chat, debe descargarse al cliente todo el árbol chats, incluidos todos los miembros y los mensajes.
      }
    },
    "two": { ... }
  }
}
```
- Se deben evitar anidaciones complejas. Provocan disminución del rendimiento, complejidad en las consultas y los permisos sobre un nodo dan acceso a todo el árbol que depende de ese nodo.

- Buscar estructuras compactas no normalizadas

```json
{
  // Chats contains only meta info about each conversation
  // stored under the chats's unique ID
  "chats": {
    "one": {
      "title": "Historical Tech Pioneers",
      "lastMessage": "ghopper: Relay malfunction found. Cause: moth.",
      "timestamp": 1459361875666
    },
    "two": { ... },
    "three": { ... }
  },

  // Conversation members are easily accessible
  // and stored by chat conversation ID
  "members": {
    // we'll talk about indices like this below
    "one": {
      "ghopper": true,
      "alovelace": true,
      "eclarke": true
    },
    "two": { ... },
    "three": { ... }
  },

  // Messages are separate from data we may want to iterate quickly
  // but still easily paginated and queried, and organized by chat
  // conversation ID
  "messages": {
    "one": {
      "m1": {
        "name": "eclarke",
        "message": "The relay seems to be malfunctioning.",
        "timestamp": 1459361875337
      },
      "m2": { ... },
      "m3": { ... }
    },
    "two": { ... },
    "three": { ... }
  }
}
```

- Indexar los datos para conseguir un subconjunto de datos:

En este caso indexamos los grupos al que pertenece un usuario y los usuarios que pertenecen a un grupo:

```json
// An index to track Ada's memberships
{
  "users": {
    "alovelace": {
      "name": "Ada Lovelace",
      // Index Ada's groups in her profile
      "groups": {
         // the value here doesn't matter, just that the key exists
         "techpioneers": true,
         "womentechmakers": true
      }
    },
    ...
  },
  "groups": {
    "techpioneers": {
      "name": "Historical Tech Pioneers",
      "members": {
        "alovelace": true,
        "ghopper": true,
        "eclarke": true
      }
    },
    ...
  }
}
```

### Instalación firebase

#### Crear una aplicación web

- Desde la consola de firebase se crea una aplicación Web.
- Guardamos los datos de configuración en el fichero `environment.ts` de la aplicación Angular

```js
firebaseConfig = {
  apiKey: "AIzaSyCew6IeHgcYT1faUPBAnihBc8s-2AX-0cU",
  authDomain: "bcnactiva01.firebaseapp.com",
  databaseURL: "https://bcnactiva01-default-rtdb.europe-west1.firebasedatabase.app",
  projectId: "bcnactiva01",
  storageBucket: "bcnactiva01.appspot.com",
  messagingSenderId: "441335904390",
  appId: "1:441335904390:web:22f51a215dba5d3a007907"
};
```

#### Instalación de la última versión del sdk de Firebase

Instalamos Firebase para Angular mediante el schematic de Angular:

```bash
ng g add @angular/fire
```

#### Carga módulos de firebase en `app.module.ts`

```ts
import { AngularFireModule } from '@angular/fire/compat';
import { AngularFireDatabaseModule } from '@angular/fire/compat/database';
...


@NgModule({
  imports: [
    AngularFireModule.initializeApp(environment.firebase),
    AngularFireDatabaseModule,

```

#### Servicio para trabajar con los datos de Realtime

```bash
ng g s shared/services/mi-service
```

- Configuramos el servicion para acceder a los datos:
