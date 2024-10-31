const { MongoClient } = require('mongodb');

const uri = "mongodb://localhost:27017";
const client = new MongoClient(uri);

async function run() {
  try {
    await client.connect();
    const   
 database = client.db('maBaseDeDonnees');
    const collection = database.collection('avis');

    const doc = {
      avis_id: "",
      utilisateur: "",
      contenu: "",
      visible: true
    };
    const result = await collection.insertOne(doc);
    console.log(`Un avis a été inséré avec l'ID : ${result.insertedId}`);
  } finally {
    await client.close();
  }
}
run().catch(console.dir);