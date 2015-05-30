Feature:
  In order to handle comments
  As a api maintainer
  I should be able to add/list comment through a REST calls

  @comment
  Scenario: add a new comment
    Given I have 2 'Cities' on my system
    Given I send a POST request to "/beach" with values:
      | city_id | 1          |
      | name    | Boca Raton |
    And there are 0 'Comment' in the system
    And 0 saved images
    When I send a POST request to "/comment" with values:
      | beach_id    | 1                                      |
      | name        | Gandalf                                |
      | lastName    | Grey                                   |
      | description | beautiful beach carved betwen 2 cliffs |
    Then the response code should be 201
    And there are 1 'Comment' in the system

  @comment
  Scenario: display a list of comments
    Given I send a POST request to "/beach" with values:
      | city_id | 1          |
      | name    | Boca Raton |
    And I send a POST request to "/comment" with values:
      | beach_id    | 1                                      |
      | name        | Gandalf                                |
      | lastName    | Grey                                   |
      | description | beautiful beach carved betwen 2 cliffs |
    When I send a GET request to "/comment"
    Then the response code should be 200
    And the response should contain json:
    """
   [
    {
        "id": 1,
        "name": "Gandalf",
        "lastName": "Grey",
        "description": "beautiful beach carved betwen 2 cliffs",
        "beach": {
            "id": 1,
            "name": "Boca Raton",
            "city": "San Francisco"
        }
    }
  ]
    """

  @comment
  Scenario: search comments by city
    Given I have 2 'Comment' on my system
    And 1 of it is from a beach from "Sicily"
    When I send a GET request to "/comment?city=2"
    Then the response code should be 200
    And the response should contain json:
    """
 [
    {
        "id": 2,
        "name": "Mimmo",
        "lastName": "Rossi",
        "description": "test",
        "beach": {
            "id": 2,
            "name": "Palermo Beach",
            "city": "Palermo"
        }
    }
]
    """