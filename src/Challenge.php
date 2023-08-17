<?php

	namespace Otto;

	use PDO;
	use PDOException;

	class Challenge
	{
		protected $pdoBuilder;

		public function __construct()
		{
			$config = require __DIR__ . '/../config/database.config.php';
			$this->setPdoBuilder(new PdoBuilder($config));
		}

		/**
		 * Use the PDOBuilder to retrieve all the records
		 *
		 * @return array
		 */
		public function getRecords()
		{
			$pdo = $this->getPdoBuilder()->getPdo();
			$sql = "SELECT d.id AS director_id,
                       CONCAT(d.first_name, ' ', d.last_name) AS director_name,
                       b.name AS business_name,
                       b.registered_address AS business_address,
                       b.registration_number AS business_registration_number
                FROM directors AS d
                JOIN businesses AS b ON d.id = b.id";
			try {
				$stmt = $pdo->query($sql);
				return $stmt->fetchAll(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		/**
		 * Use the PDOBuilder to retrieve all the director records
		 *
		 * @return array
		 */
		public function getDirectorRecords()
		{
      $pdo = $this->getPdoBuilder()->getPdo();
      $query = 'SELECT * FROM directors';
      $stmt = $pdo->query($query);
      return $stmt->fetchAll();
		}

		/**
		 * Use the PDOBuilder to retrieve a single director record with a given id
		 *
		 * @param int $id
		 * @return array
		 */
		public function getSingleDirectorRecord($id)
		{
      $pdo = $this->getPdoBuilder()->getPdo();
      $query = 'SELECT * FROM directors WHERE id = :id';
      $stmt = $pdo->prepare($query);
      $stmt->execute(['id' => $id]);
      return $stmt->fetch();
		}

		/**
		 * Use the PDOBuilder to retrieve all the business records
		 *
		 * @return array
		 */
		public function getBusinessRecords()
		{
      $pdo = $this->getPdoBuilder()->getPdo();
      $query = 'SELECT * FROM businesses';
      $stmt = $pdo->query($query);
      return $stmt->fetchAll();
		}

		/**
		 * Use the PDOBuilder to retrieve a single business record with a given id
		 *
		 * @param int $id
		 * @return array
		 */
		public function getSingleBusinessRecord($id)
		{
      $pdo = $this->getPdoBuilder()->getPdo();
      $query = 'SELECT * FROM businesses WHERE id = :id';
      $stmt = $pdo->prepare($query);
      $stmt->execute(['id' => $id]);
      return $stmt->fetch();
		}

		/**
		 * Use the PDOBuilder to retrieve a list of all businesses registered on a particular year
		 *
		 * @param int $year
		 * @return array
		 */
		public function getBusinessesRegisteredInYear($year)
		{
      $pdo = $this->getPdoBuilder()->getPdo();
      $query = 'SELECT * FROM businesses WHERE YEAR(registration_date) = :year';
      $stmt = $pdo->prepare($query);
      $stmt->execute(['year' => $year]);
      return $stmt->fetchAll();
		}

		/**
		 * Use the PDOBuilder to retrieve the last 100 records in the directors table
		 *
		 * @return array
		 */
		public function getLast100Records()
		{
      $pdo = $this->getPdoBuilder()->getPdo();
      $query = 'SELECT * FROM directors ORDER BY id DESC LIMIT 100';
      $stmt = $pdo->query($query);
      return $stmt->fetchAll();
		}

		/**
		 * Use the PDOBuilder to retrieve a list of all business names with the director's name in a separate column.
		 * The links between directors and businesses are located inside the director_businesses table.
		 *
		 * Your result schema should look like this;
		 *
		 * | business_name | director_name |
		 * ---------------------------------
		 * | some_company  | some_director |
		 *
		 * @return array
		 */
		public function getBusinessNameWithDirectorFullName()
		{
      $pdo = $this->getPdoBuilder()->getPdo();
      $query = "SELECT b.name AS business_name, CONCAT(d.first_name, ' ', d.last_name) AS director_name
              FROM businesses b
              INNER JOIN director_businesses db ON b.id = db.business_id
              INNER JOIN directors d ON db.director_id = d.id";
      $stmt = $pdo->query($query);
      return $stmt->fetchAll();
		}

		/**
		 * @param PdoBuilder $pdoBuilder
		 * @return $this
		 */
		public function setPdoBuilder(PdoBuilder $pdoBuilder)
		{
			$this->pdoBuilder = $pdoBuilder;
			return $this;
		}

		/**
		 * @return PdoBuilder
		 */
		public function getPdoBuilder()
		{
			return $this->pdoBuilder;
		}
	}
