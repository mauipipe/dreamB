Feature:
  In order to handle a beach
  As a api maintainer
  I should be able to add a beach to the db

  @beach
  Scenario: Add a beach
    Given there are 0 'Beach' in the system
    When I send a POST request to "/beach" with values:
      | city_id | 1          |
      | name    | Boca Raton |
    Then the response code should be 201
    And there are 1 'Beach' in the system

  @beach
  Scenario: display a list of beaches
    Given I have 2 'Beach' on my system
    When I send a GET request to "/beach"
    Then the response code should be 200
    And the response should contain json:
    """
   [
    {
        "id": 1,
        "name": "Bay Beach",
        "slug": "bay-beach",
        "city": "San Francisco"
    },
    {
        "id": 2,
        "name": "Palermo Beach",
        "slug": "palermo-beach",
        "city": "Palermo"
    }
]
    """

